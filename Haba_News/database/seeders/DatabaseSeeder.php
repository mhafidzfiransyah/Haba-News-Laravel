<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\News;
use App\Models\Visitor;
use App\Models\ActivityLog;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT USER & ADMIN
        User::create([
            'name' => 'Admin Ganteng',
            'email' => 'admin@haba.com',
            'password' => Hash::make('password'), // Password login
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Asep Knalpot',
            'email' => 'asep@mail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@mail.com',
            'password' => Hash::make('password'),
        ]);

        // 2. BUAT DATA PENGUNJUNG (7 HARI TERAKHIR) UNTUK GRAFIK
        // Kita buat data acak biar grafiknya naik turun
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $jumlahPengunjung = rand(50, 200); // Random 50-200 orang per hari

            for ($j = 0; $j < $jumlahPengunjung; $j++) {
                Visitor::create([
                    'ip_address' => '192.168.1.' . rand(1, 255),
                    'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X)',
                    'visit_date' => $date->format('Y-m-d') // Penting format tanggal
                ]);
            }
        }

        // 3. BUAT BERITA DUMMY
        $news1 = News::create([
            'title' => 'Harga Cabai di Pasar Induk Mulai Turun',
            'slug' => 'harga-cabai-turun',
            'desc' => 'Setelah sempat melambung tinggi, harga cabai kini mulai stabil.',
            'content' => 'Jakarta - Harga cabai merah keriting di sejumlah pasar tradisional mulai menunjukkan penurunan...',
            'image' => 'https://images.unsplash.com/photo-1588710929779-4a227856a7a6?auto=format&fit=crop&w=600&q=80',
            'category' => 'Ekonomi',
            'author' => 'Admin',
            'status' => 'published',
            'is_verified' => true,
            'ai_trust_score' => 95,
            'views' => 1250,
            'is_hot' => true
        ]);

        News::create([
            'title' => 'Tutorial Laravel 12 untuk Pemula',
            'slug' => 'tutorial-laravel-12',
            'desc' => 'Panduan lengkap instalasi dan konfigurasi awal Laravel 12.',
            'content' => 'Laravel 12 membawa banyak fitur baru yang memudahkan developer...',
            'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=600&q=80',
            'category' => 'Teknologi',
            'author' => 'Programmer Zaman Now',
            'status' => 'published',
            'is_verified' => true,
            'ai_trust_score' => 98,
            'views' => 850
        ]);

        // Berita Draft (Hoax)
        News::create([
            'title' => 'HEBOH! Ditemukan Harta Karun di Belakang Rumah',
            'slug' => 'heboh-harta-karun',
            'desc' => 'Warga geger menemukan emas batangan saat menggali sumur.',
            'content' => 'Belum dipastikan kebenarannya, namun warga sudah berkumpul...',
            'image' => 'https://images.unsplash.com/photo-1605152276897-4f618f831968?auto=format&fit=crop&w=600&q=80',
            'category' => 'Sosial',
            'author' => 'Netizen',
            'status' => 'draft',
            'is_verified' => false,
            'ai_trust_score' => 30, // Rendah karena clickbait
            'ai_analysis' => 'Judul mengandung kata provokatif "HEBOH".'
        ]);

        // 4. BUAT KOMENTAR
        Comment::create([
            'news_id' => $news1->id,
            'name' => 'Ibu Rumah Tangga',
            'text' => 'Alhamdulillah kalau turun, kemarin mahal banget!',
            'avatar' => 'https://ui-avatars.com/api/?name=Ibu+RT'
        ]);

        // 5. LOG AKTIVITAS
        ActivityLog::create([
            'user_name' => 'Asep Knalpot',
            'action' => 'Komentar di berita',
            'target' => 'Harga Cabai...',
            'type' => 'comment'
        ]);
        
        ActivityLog::create([
            'user_name' => 'Siti Aminah',
            'action' => 'Membaca berita',
            'target' => 'Tutorial Laravel...',
            'type' => 'view'
        ]);
    }
}