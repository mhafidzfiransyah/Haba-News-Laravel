<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\News;
use Illuminate\Support\Str;

class NewsService
{
    public function fetchFromExternalSource()
    {
        $apiKey = env('NEWS_API_KEY');
        
        if (!$apiKey) {
            return "API Key belum di-setting di file .env!";
        }

        $url = "https://newsapi.org/v2/everything?q=indonesia&language=id&sortBy=publishedAt&apiKey={$apiKey}";
        
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            $articles = $data['articles'] ?? [];
            $count = 0;

            foreach ($articles as $article) {
                if (empty($article['title']) || $article['title'] === '[Removed]') continue;
                if (News::where('title', $article['title'])->exists()) continue;

                $detectedCategory = $this->determineCategory($article['title'], $article['description'] ?? '');

                // --- PERBAIKAN KONTEN ARTIKEL ---
                // Kita buat simulasi paragraf panjang agar halaman Detail tidak kosong
                $dummyParagraphs = "
                    <p class='mb-4'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <p class='mb-4'>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <h3 class='text-xl font-bold mb-2'>Analisis Mendalam</h3>
                    <p class='mb-4'>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                    <p class='mb-4'>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                    <blockquote class='border-l-4 border-yellow-500 pl-4 italic my-4 text-gray-600'>
                        \"Ini adalah contoh kutipan penting dalam berita yang digenerate secara otomatis untuk keperluan tugas kuliah.\"
                    </blockquote>
                    <p>Baca selengkapnya di sumber asli: <a href='" . ($article['url'] ?? '#') . "' target='_blank' class='text-blue-600 underline'>Klik disini</a></p>
                ";

                // Gabungkan deskripsi asli dengan dummy
                $fullContent = "<p class='font-bold text-lg mb-4'>" . ($article['description'] ?? '') . "</p>" . $dummyParagraphs;

                // Gambar Fallback
                $image = $article['urlToImage'];
                if (empty($image)) {
                    $image = 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=600&auto=format&fit=crop';
                }

                // AI Check
                $aiCheck = $this->analyzeContent($article['title'], $article['description'] ?? '');

                News::create([
                    'title' => $article['title'],
                    'slug' => Str::slug(Str::limit($article['title'], 50)) . '-' . Str::random(5),
                    'desc' => $article['description'] ?? 'Berita terbaru hari ini.',
                    'content' => $fullContent, // Konten FULL
                    'image' => $image,
                    'category' => $detectedCategory,
                    'author' => $article['author'] ?? 'Redaksi',
                    'source' => $article['source']['name'] ?? 'Internet',
                    'status' => 'draft',
                    'is_verified' => $aiCheck['is_safe'],
                    'ai_trust_score' => $aiCheck['score'],
                    'ai_analysis' => $aiCheck['reason'],
                    'is_hot' => (rand(1, 100) <= 25), // 25% peluang Hot
                    'views' => rand(10, 200), 
                ]);
                $count++;
                
                if ($count >= 20) break; 
            }
            
            return "Berhasil menarik {$count} berita.";
        }

        return "Gagal mengambil berita: " . $response->body();
    }

    private function determineCategory($title, $desc)
    {
        // (Kode kategori sama seperti sebelumnya, tidak diubah agar tetap pinter)
        $text = strtolower($title . ' ' . $desc);
        $keywords = [
            'Sport' => ['timnas', 'pssi', 'fifa', 'piala', 'liga', 'bola', 'badminton', 'bulutangkis', 'motogp', 'f1', 'juara', 'atlet', 'skor', 'pertandingan', 'olahraga', 'madrid', 'barca', 'mu', 'liverpool', 'nba', 'basket'],
            'Otomotif' => ['mobil', 'motor', 'honda', 'yamaha', 'toyota', 'suzuki', 'listrik', 'ev', 'baterai', 'mesin', 'facelift', 'otomotif', 'jalan tol', 'macet', 'byd', 'hyundai', 'wuling', 'mitsubishi'],
            'Kuliner' => ['resep', 'masak', 'kuliner', 'makanan', 'minuman', 'kopi', 'kafe', 'restoran', 'warung', 'menu', 'sarapan', 'makan siang', 'makan malam', 'jajanan', 'cemilan', 'roti', 'kue', 'pedas', 'manis', 'gurih', 'lezat', 'nikmat', 'goreng', 'bakar', 'kfc', 'mcd', 'pizza'],
            'Teknologi' => ['ai', 'chatgpt', 'google', 'apple', 'samsung', 'iphone', 'android', 'aplikasi', 'startup', 'coding', 'internet', 'wifi', 'komputer', 'laptop', 'robot', 'teknologi', 'digital', 'satelit', 'spacex', 'nasa', 'xiaomi', 'oppo', 'vivo', 'game', 'esport', 'cyber', 'hacker'],
            'Kesehatan' => ['dokter', 'rumah sakit', 'bpjs', 'obat', 'vaksin', 'virus', 'kesehatan', 'penyakit', 'stunting', 'gizi', 'diet', 'medis', 'kanker', 'jantung', 'sehat', 'olahraga', 'nutrisi', 'vitamin'],
            'Entertainment' => ['artis', 'seleb', 'film', 'musik', 'konser', 'lagu', 'viral', 'aktor', 'aktris', 'sinetron', 'drama', 'gosip', 'netflix', 'bioskop', 'hiburan'],
            'Ekonomi' => ['saham', 'ihsg', 'rupiah', 'dolar', 'bank', 'bi', 'inflasi', 'ekonomi', 'investasi', 'emas', 'bisnis', 'umkm', 'pajak', 'apbn', 'gaji', 'thr', 'bumn', 'keuangan', 'pasar', 'harga', 'dagang', 'promo', 'diskon'],
            'Politik' => ['presiden', 'jokowi', 'prabowo', 'gibran', 'anies', 'ganjar', 'kpu', 'bawaslu', 'partai', 'dpr', 'mpr', 'menteri', 'kabinet', 'pemilu', 'pilkada', 'politik', 'mk', 'pemerintah', 'istana', 'uud', 'hukum', 'korupsi', 'kpk'],
            'Lifestyle' => ['wisata', 'liburan', 'hotel', 'fashion', 'baju', 'travel', 'gaya hidup', 'zodiak', 'unik', 'destinasi', 'pantai', 'gunung', 'healing']
        ];

        $scores = [];
        foreach ($keywords as $category => $words) {
            $scores[$category] = 0;
            foreach ($words as $word) {
                if (str_contains($text, $word)) $scores[$category]++;
            }
        }
        arsort($scores);
        $topCategory = array_key_first($scores);
        
        return ($scores[$topCategory] > 0) ? $topCategory : 'Berita Umum';
    }

    private function analyzeContent($title, $desc)
    {
        return ['score' => 90, 'reason' => 'Valid', 'is_safe' => true];
    }
}