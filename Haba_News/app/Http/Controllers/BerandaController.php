<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Visitor;
use Carbon\Carbon;

class BerandaController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        // 1. TRACKING VISITOR
        Visitor::firstOrCreate([
            'ip_address' => $request->ip(),
            'visit_date' => Carbon::today()
        ], [
            'user_agent' => $request->header('User-Agent')
        ]);

        // 2. LOGIKA HERO (HOT NEWS) - SELALU DIAMBIL
        // Kita ambil berita yang statusnya HOT, terlepas dari filter kategori
        $baseQuery = News::published();
        
        $heroNews = (clone $baseQuery)->where('is_hot', true)->latest()->first();
        // Fallback: Jika tidak ada berita hot, ambil sembarang berita terbaru
        if (!$heroNews) {
            $heroNews = (clone $baseQuery)->latest()->first();
        }

        // 3. LOGIKA SUB HERO (2 Berita Samping Hero)
        $subHeroNews = collect([]);
        if ($heroNews) {
            $subHeroNews = (clone $baseQuery)
                            ->where('id', '!=', $heroNews->id)
                            ->latest()
                            ->take(2)
                            ->get();
        }

        // 4. LOGIKA LIST BERITA BAWAH (FILTERING)
        $query = News::published()->latest(); // Reset query untuk list bawah
        $activeCategory = 'Semua';

        // Filter Kategori (Slug)
        if ($slug && strtolower($slug) !== 'semua') {
            $cleanSlug = str_replace('-', ' ', $slug);
            $activeCategory = ucwords($cleanSlug);
            $query->where('category', 'LIKE', "%{$cleanSlug}%");
        }

        // Filter Search
        if ($request->has('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('desc', 'LIKE', "%{$search}%");
            });
        }

        // Exclude Hero & Subhero agar tidak muncul dobel di bawah
        // TAPI: Kalau sedang difilter kategori, kita biarkan saja muncul lagi di bawah
        // supaya user tetap bisa melihat berita tersebut dalam konteks kategorinya.
        // (Opsional: kalau mau strict exclude, uncomment baris bawah ini)
        // if ($activeCategory === 'Semua') {
             $excludeIds = collect([$heroNews->id ?? 0])->merge($subHeroNews->pluck('id'));
             $query->whereNotIn('id', $excludeIds);
        // }

        $newsList = $query->paginate(6);

        // 5. LOGIKA KATEGORI DINAMIS (Auto-Add)
        // Ambil semua kategori unik yang ada di database berita yang sudah publish
        // Urutkan sesuai abjad
        $categories = News::published()
                        ->select('category')
                        ->distinct()
                        ->orderBy('category', 'ASC')
                        ->pluck('category');

        return view('Beranda.semua', compact('heroNews', 'subHeroNews', 'categories', 'newsList', 'activeCategory'));
    }
    
    public function about()
    {
        return view('About.index');
    }
}