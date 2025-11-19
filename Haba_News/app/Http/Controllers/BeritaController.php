<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeritaController extends Controller
{
    // Method 'show' standar Laravel untuk menampilkan 1 item detail
    public function show($id)
    {
        // 1. Ambil Data Dummy (Nanti ini diganti sama: News::find($id))
        $allNews = $this->getDummyNews();
        
        // 2. Cari berita berdasarkan ID
        $news = collect($allNews)->firstWhere('id', $id);

        // Fallback: Kalau ID tidak ketemu, ambil data pertama biar ga error
        if (!$news) {
            abort(404); // Atau redirect, tapi disini kita 404 kan saja kalau ga ada
        }

        // 3. Data Dummy Komentar (Khusus halaman detail)
        $comments = [
            [
                'name' => 'Bahlil Bahlul',
                'avatar' => 'https://i.pravatar.cc/150?u=1',
                'text' => 'Saya bahlil, saya jelek, bodoh, ga kompeten, dan hoby saya adalah korupsi uang rakyat.',
                'time' => '24 Balas',
            ],
            [
                'name' => 'Jokowi Dododo',
                'avatar' => 'https://i.pravatar.cc/150?u=2',
                'text' => 'Kalau dibilang untuk mengganti produk lokal. Jadi gini sebenarnya kita nggak keberatan diganti dengan produk lokal.',
                'time' => '2 Jam lalu',
            ],
             [
                'name' => 'Netizen +62',
                'avatar' => 'https://i.pravatar.cc/150?u=3',
                'text' => 'Halah, paling cuman pengalihan isu doang ini mah.',
                'time' => '5 Menit lalu',
            ]
        ];

        // 4. Data Dummy Berita Serupa (Sidebar)
        $relatedNews = [
             [
                'title' => 'Jokowi Kawin lagi dengan janda',
                'category' => 'Politik',
                'image' => 'https://images.unsplash.com/photo-1541872703-74c5e1d51d47?q=80&w=200&auto=format&fit=crop',
                'verified' => true
            ],
            [
                'title' => 'Harga Cabe Naik Drastis',
                'category' => 'Ekonomi',
                'image' => 'https://images.unsplash.com/photo-1611974765270-ca1258634369?q=80&w=200&auto=format&fit=crop',
                'verified' => true
            ],
            [
                'title' => 'Timnas Menang Lawan Argentina',
                'category' => 'Sport',
                'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=200&auto=format&fit=crop',
                'verified' => true
            ]
        ];

        // 5. Return View
        // Pastikan kamu punya file view di: resources/views/Berita/detail.blade.php
        // Atau kalau masih di folder Beranda, ganti jadi 'Beranda.detail'
        return view('Berita.detail', compact('news', 'comments', 'relatedNews'));
    }

    // Helper Data Dummy (Sama seperti di Beranda, karena kita belum pakai Database)
    private function getDummyNews() {
        return [
            [
                'id' => 1,
                'title' => 'Bahlil Korupsi tapi tidak di hukum oleh hakim.',
                'desc' => 'Jakarta - Pedagang barang bekas (thrifting) menanggapi terkait rencana pemerintah dalam upaya penertiban barang bekas impor...',
                'content' => '<p class="mb-4">Jakarta - Pedagang barang bekas (thrifting) menanggapi terkait rencana pemerintah dalam upaya penertiban barang bekas impor, termasuk pakaian bekas. Pedagang diminta untuk beralih menjual ke produk lokal.</p><p class="mb-4">Pedagang Thrifting di Pasar Senen, Rifai Silalahi mengaku tidak keberatan terkait rencana tersebut. Namun, ia meragukan rencana ini dapat diterima oleh segmen pasar mereka.</p><p class="mb-4">"Kalau dibilang untuk mengganti produk lokal. Jadi gini sebenarnya kita nggak keberatan diganti dengan produk lokal, tapi pertanyaannya adalah apakah ini akan diterima masyarakat kan butuh penyesuaian juga," ujar Rifai saat dijumpai di Gedung DPR RI.</p>',
                'category' => 'Politik',
                'image' => 'https://images.unsplash.com/photo-1612151855475-877969f4a6cc?q=80&w=1000&auto=format&fit=crop',
                'verified' => true,
                'author' => 'Jokowi dododo',
                'author_avatar' => 'https://i.pravatar.cc/150?u=99',
                'date' => '02 jam yang lalu',
                'views' => '1240 Views'
            ],
            [
                'id' => 2,
                'title' => 'Startup Teknologi Lokal Raih Pendanaan Series A',
                'desc' => 'Kabar gembira bagi ekosistem startup indonesia...',
                'content' => '<p class="mb-4">Isi berita teknologi disini...</p>',
                'category' => 'Teknologi',
                'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1000&auto=format&fit=crop',
                'verified' => false,
                'author' => 'Admin Tech',
                'author_avatar' => 'https://i.pravatar.cc/150?u=50',
                'date' => '1 Hari lalu',
                'views' => '800 Views'
            ],
            // Tambahkan dummy data lain sesuai kebutuhan
        ];
    }
}