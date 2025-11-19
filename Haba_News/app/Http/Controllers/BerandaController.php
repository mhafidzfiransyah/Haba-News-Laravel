<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        // --- 1. DATA HERO (Tetap) ---
        $heroNews = [
            'id' => 999, 
            'title' => 'Bahlil Mencampurkan Pertalite dengan Etanol',
            'desc' => 'Mentri ESDM, Bahlil Bahlul berkata dalam sebuah wawancara, kalau dia akan menggabungkan Etanol dengan pertalite...',
            'category' => 'Politik',
            'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?q=80&w=1000&auto=format&fit=crop',
            'author' => 'Verified',
            'verified' => true
        ];

        // --- 2. DATA SUB HERO (Tetap) ---
        $subHeroNews = [
            [
                'id' => 881,
                'title' => 'Ijazah Jokowi Ternyata Palsu',
                'desc' => 'Ijazah Jokowi terbukti palsu ketika di buktikan oleh tim forensik...',
                'category' => 'Hukum',
                'image' => 'https://images.unsplash.com/photo-1555848962-6e79363ec58f?q=80&w=600&auto=format&fit=crop',
                'verified' => true
            ],
            [
                'id' => 882,
                'title' => 'Skandal Korupsi Terbesar Tahun Ini',
                'desc' => 'KPK berhasil menangkap tangan pejabat yang sedang transaksi...',
                'category' => 'Hukum',
                'image' => 'https://images.unsplash.com/photo-1505664194779-8beaceb93744?q=80&w=600&auto=format&fit=crop',
                'verified' => true
            ]
        ];

        // --- 3. DATA LIST BERITA (Update Verified) ---
        $allNews = [];
        for ($i = 1; $i <= 12; $i++) {
            $allNews[] = [
                'id' => $i,
                'title' => "Berita Nomor $i: Bahlil dan Jokowi Bersekongkol?",
                'desc' => "Ini adalah deskripsi singkat untuk berita nomor $i. Bahlil bodoh banget anjing, jelek, gelo masa bisa bisanya dia...",
                'category' => ($i % 2 == 0) ? 'Teknologi' : 'Politik', 
                'image' => 'https://images.unsplash.com/photo-1612151855475-877969f4a6cc?q=80&w=600&auto=format&fit=crop',
                
                // PERBAIKAN: Saya set TRUE semua biar verified-nya muncul terus
                'verified' => true 
            ];
        }

        $categories = ['Politik', 'Teknologi', 'Ekonomi', 'Kesehatan', 'Budaya', 'Entertainment', 'Sport', 'Otomotif'];

        // --- 4. LOGIKA PAGINATION & FILTER ---
        $activeCategory = $slug ? ucfirst($slug) : 'Semua';
        
        // Filter
        if ($slug && strtolower($slug) !== 'semua') {
            $filteredNews = array_filter($allNews, function($item) use ($activeCategory) {
                return strtolower($item['category']) === strtolower($activeCategory);
            });
        } else {
            $filteredNews = $allNews;
        }

        // Pagination Logic
        $page = $request->get('page', 1); 
        $perPage = 4; 
        $total = count($filteredNews);
        $totalPages = ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;
        $newsList = array_slice($filteredNews, $offset, $perPage);

        return view('Beranda.semua', compact(
            'heroNews', 
            'subHeroNews', 
            'categories', 
            'newsList', 
            'activeCategory',
            'page',       
            'totalPages'  
        ));
    }
}