<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaController extends Controller
{
    // ... (Method index biarkan seperti yang terakhir kita revisi) ...

    public function index(Request $request, $slug = null)
    {
        // ... (Kode index yang pagination & verified tadi biarkan disini) ...
        // Supaya tidak kepanjangan, saya tidak tulis ulang method index-nya ya.
        // Pastikan kode index kamu yang terakhir (Pagination loop) tetap ada.
        
        // SAYA TULIS ULANG BIAR PASTI KAMU GAK BINGUNG NARUHNYA DIMANA
        // --- COPY DARI SINI JIKA MAU FULL REPLACE ---
        
        // 1. DATA HERO
        $heroNews = [
            'id' => 999, 'title' => 'Bahlil Mencampurkan Pertalite dengan Etanol',
            'desc' => 'Mentri ESDM, Bahlil Bahlul berkata dalam sebuah wawancara...',
            'category' => 'Politik',
            'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?q=80&w=1000&auto=format&fit=crop',
            'author' => 'Verified', 'verified' => true
        ];

        // 2. DATA SUB HERO
        $subHeroNews = [
            ['id' => 881, 'title' => 'Ijazah Jokowi Ternyata Palsu', 'desc' => '...', 'category' => 'Hukum', 'image' => 'https://images.unsplash.com/photo-1555848962-6e79363ec58f?q=80&w=600&auto=format&fit=crop', 'verified' => true],
            ['id' => 882, 'title' => 'Skandal Korupsi Terbesar Tahun Ini', 'desc' => '...', 'category' => 'Hukum', 'image' => 'https://images.unsplash.com/photo-1505664194779-8beaceb93744?q=80&w=600&auto=format&fit=crop', 'verified' => true]
        ];

        // 3. LIST BERITA
        $allNews = [];
        for ($i = 1; $i <= 12; $i++) {
            $allNews[] = [
                'id' => $i,
                'title' => "Berita Nomor $i: Bahlil dan Jokowi Bersekongkol?",
                'desc' => "Ini adalah deskripsi singkat...",
                'category' => ($i % 2 == 0) ? 'Teknologi' : 'Politik', 
                'image' => 'https://images.unsplash.com/photo-1612151855475-877969f4a6cc?q=80&w=600&auto=format&fit=crop',
                'verified' => true 
            ];
        }
        $categories = ['Politik', 'Teknologi', 'Ekonomi', 'Kesehatan', 'Budaya', 'Entertainment', 'Sport', 'Otomotif'];

        // LOGIKA
        $activeCategory = $slug ? ucfirst($slug) : 'Semua';
        if ($slug && strtolower($slug) !== 'semua') {
            $filteredNews = array_filter($allNews, fn($item) => strtolower($item['category']) === strtolower($activeCategory));
        } else {
            $filteredNews = $allNews;
        }

        $page = $request->get('page', 1); 
        $perPage = 4; 
        $total = count($filteredNews);
        $totalPages = ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;
        $newsList = array_slice($filteredNews, $offset, $perPage);

        return view('Beranda.semua', compact('heroNews', 'subHeroNews', 'categories', 'newsList', 'activeCategory', 'page', 'totalPages'));
    }

    // --- METHOD BARU UNTUK ABOUT ---
    public function about()
    {
        return view('About.index');
    }
}