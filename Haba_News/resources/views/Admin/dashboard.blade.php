@extends('Admin.layout')

@section('title', 'Dashboard & Verifikasi')

@section('content')
    
    {{-- 1. KARTU STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-blue-500 flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4"><i class="fas fa-users text-2xl"></i></div>
            <div><p class="text-gray-500 text-xs font-bold uppercase">Total Pengunjung</p><h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_visitors']) }}</h3></div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-yellow-500 flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4"><i class="fas fa-newspaper text-2xl"></i></div>
            <div><p class="text-gray-500 text-xs font-bold uppercase">Total Berita</p><h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_news'] }}</h3></div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-red-500 flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4"><i class="fas fa-exclamation-triangle text-2xl"></i></div>
            <div><p class="text-gray-500 text-xs font-bold uppercase">Laporan User</p><h3 class="text-2xl font-bold text-gray-800">{{ $stats['pending_reports'] }}</h3></div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-green-500 flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4"><i class="fas fa-user-check text-2xl"></i></div>
            <div><p class="text-gray-500 text-xs font-bold uppercase">User Aktif</p><h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</h3></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        {{-- 2. GRAFIK PENGUNJUNG (Chart.js) --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800 text-lg">Statistik Pengunjung</h3>
                <select class="text-xs border-gray-300 border rounded p-1 bg-gray-50 text-gray-600">
                    <option>Tahun Ini</option>
                    <option>Bulan Ini</option>
                    <option>Minggu Ini</option>
                </select>
            </div>
            <div class="relative h-64 w-full">
                {{-- PERBAIKAN: Data disimpan di atribut HTML (data-*) agar aman dari error syntax JS --}}
                <canvas id="visitorChart" 
                        data-chart-labels='@json($chartData['labels'])' 
                        data-chart-values='@json($chartData['data'])'>
                </canvas>
            </div>
        </div>

        {{-- 3. LOG AKTIVITAS USER --}}
        <div class="bg-white rounded-xl shadow-sm p-6 overflow-hidden">
            <h3 class="font-bold text-gray-800 text-lg mb-4">Aktivitas User Terbaru</h3>
            <div class="space-y-4 max-h-64 overflow-y-auto pr-2 custom-scroll">
                @foreach($userActivities as $act)
                <div class="flex items-start space-x-3 pb-3 border-b border-gray-100 last:border-0">
                    <img src="{{ $act['avatar'] }}" class="w-8 h-8 rounded-full bg-gray-200">
                    <div class="flex-1">
                        <p class="text-xs text-gray-800">
                            <span class="font-bold">{{ $act['user'] }}</span> {{ $act['action'] }} <span class="text-blue-600 font-medium">{{ $act['target'] }}</span>
                        </p>
                        <span class="text-[10px] text-gray-400 flex items-center mt-1">
                            <i class="far fa-clock mr-1"></i> {{ $act['time'] }}
                        </span>
                    </div>
                    @if($act['type'] == 'report')
                        <span class="w-2 h-2 rounded-full bg-red-500" title="Laporan"></span>
                    @endif
                </div>
                @endforeach
            </div>
            <a href="#" class="block text-center text-xs text-blue-600 mt-4 hover:underline">Lihat Semua Aktivitas</a>
        </div>
    </div>

    {{-- 4. TABEL VERIFIKASI BERITA (DRAFT) --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-10">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-red-50">
            <div class="flex items-center space-x-2">
                <div class="bg-red-100 text-red-600 p-2 rounded-lg"><i class="fas fa-tasks"></i></div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Menunggu Verifikasi</h3>
                    <p class="text-xs text-gray-500">Berita draft yang perlu persetujuan admin</p>
                </div>
            </div>
            <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">{{ count($pendingNews) }} Pending</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-bold">
                    <tr>
                        <th class="px-6 py-4 w-20">Foto</th>
                        <th class="px-6 py-4">Judul & Sumber</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pendingNews as $news)
                    <tr class="hover:bg-red-50/30 transition group">
                        <td class="px-6 py-4">
                            <img src="{{ $news['image'] }}" class="w-16 h-12 object-cover rounded-lg shadow-sm border border-gray-200">
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800 text-base mb-1">{{ $news['title'] }}</div>
                            <div class="text-xs text-gray-500 flex items-center">
                                <i class="fas fa-user-edit mr-1"></i> {{ $news['source'] }}
                                <span class="mx-2">•</span>
                                <i class="far fa-clock mr-1"></i> {{ $news['date'] }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                {{ $news['category'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center space-x-3">
                                {{-- Tombol REJECT --}}
                                <button class="group/btn flex items-center justify-center w-10 h-10 rounded-full bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition shadow-sm" title="Tolak / Hapus">
                                    <i class="fas fa-times"></i>
                                </button>
                                
                                {{-- Tombol APPROVE --}}
                                <button class="group/btn flex items-center justify-center w-10 h-10 rounded-full bg-green-100 text-green-600 hover:bg-green-600 hover:text-white transition shadow-sm" title="Setujui & Publish">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(count($pendingNews) == 0)
                <div class="p-6 text-center text-gray-500 text-sm">
                    <i class="fas fa-check-circle text-4xl mb-2 text-green-200"></i>
                    <p>Tidak ada berita yang perlu diverifikasi saat ini.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- SCRIPT CHART.JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil elemen canvas
            const canvas = document.getElementById('visitorChart');
            
            // Ambil data JSON dari atribut HTML (Cara paling aman)
            // Jika data kosong atau error, gunakan default array kosong
            let chartLabels = [];
            let chartValues = [];

            try {
                chartLabels = JSON.parse(canvas.getAttribute('data-chart-labels'));
                chartValues = JSON.parse(canvas.getAttribute('data-chart-values'));
            } catch (e) {
                console.error("Gagal memparsing data grafik:", e);
            }

            const ctx = canvas.getContext('2d');
            const visitorChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Pengunjung',
                        data: chartValues,
                        borderColor: '#3b82f6', // Blue 500
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.4, // Kurva halus
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4], color: '#f3f4f6' },
                            ticks: { font: { size: 10 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        }
                    }
                }
            });
        });
    </script>
@endsection