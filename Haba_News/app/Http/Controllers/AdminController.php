<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Statistik Kartu
        $stats = [
            'total_news' => 1240,
            'total_visitors' => 85200, // Total visitor
            'total_users' => 350,
            'pending_reports' => 5 // Laporan konten dari user
        ];

        // 2. Data untuk Grafik Pengunjung (Chart.js)
        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
            'data' => [12000, 19000, 3000, 5000, 20000, 35000, 45000] // Contoh data naik turun
        ];

        // 3. Berita Draft (Butuh Verifikasi)
        $pendingNews = [
            [
                'id' => 101,
                'title' => 'Ditemukan Cadangan Minyak Baru di Laut Jawa',
                'source' => 'Jurnalis Lapangan: Budi Santoso',
                'image' => 'https://images.unsplash.com/photo-1518459384564-dc1b27c03361?q=80&w=200&auto=format&fit=crop',
                'date' => 'Baru saja',
                'category' => 'Ekonomi'
            ],
            [
                'id' => 102,
                'title' => 'Tutorial Laravel 12 Lengkap Untuk Pemula',
                'source' => 'Kontributor: Programmer Zaman Now',
                'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=200&auto=format&fit=crop',
                'date' => '10 Menit lalu',
                'category' => 'Teknologi'
            ]
        ];

        // 4. Log Aktivitas User Terbaru
        $userActivities = [
            [
                'user' => 'Asep Knalpot',
                'avatar' => 'https://i.pravatar.cc/150?u=asep',
                'action' => 'Mengomentari berita',
                'target' => '"Harga Cabai Naik Drastis"',
                'time' => '2 Menit lalu',
                'type' => 'comment'
            ],
            [
                'user' => 'Siti Aminah',
                'avatar' => 'https://i.pravatar.cc/150?u=siti',
                'action' => 'Menyukai postingan',
                'target' => '"Tutorial Masak Rendang"',
                'time' => '15 Menit lalu',
                'type' => 'like'
            ],
            [
                'user' => 'Budi Doremi',
                'avatar' => 'https://i.pravatar.cc/150?u=budi',
                'action' => 'Melaporkan komentar',
                'target' => 'Komentar mengandung SARA',
                'time' => '1 Jam lalu',
                'type' => 'report' // Ini nanti memicu notifikasi
            ]
        ];

        return view('Admin.dashboard', compact('stats', 'chartData', 'pendingNews', 'userActivities'));
    }

    public function berita()
    {
        $allNews = $this->getDummyNews(10);
        
        // GANTI DARI 'Admin.berita.index' MENJADI 'Admin.berita.kelola'
        return view('Admin.berita.kelola', compact('allNews'));
    }

    public function users()
    {
        // Dummy Data Users
        $users = [
            ['id' => 1, 'name' => 'Asep Knalpot', 'email' => 'asep@mail.com', 'joined' => '12 Jan 2025', 'status' => 'Active'],
            ['id' => 2, 'name' => 'Siti Aminah', 'email' => 'siti@mail.com', 'joined' => '10 Feb 2025', 'status' => 'Active'],
            ['id' => 3, 'name' => 'Joko Anwar', 'email' => 'joko@mail.com', 'joined' => '05 Mar 2025', 'status' => 'Banned'],
        ];
        return view('Admin.users.index', compact('users'));
    }

    public function userActivity($id)
    {
        // Detail aktivitas user tertentu (Nanti di view bisa dibuat list timeline)
        return "Halaman Detail Aktivitas User ID: " . $id;
    }

    private function getDummyNews($limit = 10) {
        // (Helper sama seperti sebelumnya)
        $data = [];
        for($i=1; $i<=$limit; $i++) {
            $data[] = [
                'id' => $i,
                'title' => 'Contoh Berita Dummy Admin Panel No ' . $i,
                'category' => ($i % 2 == 0) ? 'Teknologi' : 'Politik',
                'author' => 'Admin',
                'date' => date('d M Y'),
                'status' => ($i % 3 == 0) ? 'Draft' : 'Published', 
                'image' => 'https://images.unsplash.com/photo-1612151855475-877969f4a6cc?q=80&w=200&auto=format&fit=crop',
            ];
        }
        return $data;
    }
}