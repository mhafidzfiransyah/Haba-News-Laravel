@extends('Admin.layout')

@section('title', 'Dashboard & Verifikasi')

@section('content')

{{-- TAMBAHKAN CDN CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- 1. KARTU STATISTIK --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Kartu Pengunjung -->
    <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-blue-500 flex items-center">
        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4"><i class="fas fa-users text-2xl"></i></div>
        <div>
            <p class="text-gray-500 text-xs font-bold uppercase">Total Pengunjung</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_visitors'] ?? 0) }}</h3>
        </div>
    </div>
    <!-- Kartu Berita -->
    <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-yellow-500 flex items-center">
        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4"><i class="fas fa-newspaper text-2xl"></i></div>
        <div>
            <p class="text-gray-500 text-xs font-bold uppercase">Total Berita</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_news'] ?? 0) }}</h3>
        </div>
    </div>
    <!-- Kartu Pending -->
    <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-red-500 flex items-center">
        <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4"><i class="fas fa-tasks text-2xl"></i></div>
        <div>
            <p class="text-gray-500 text-xs font-bold uppercase">Perlu Verifikasi</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['pending_reports'] ?? 0 }}</h3>
        </div>
    </div>
    <!-- Kartu User -->
    <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-green-500 flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4"><i class="fas fa-user-check text-2xl"></i></div>
        <div>
            <p class="text-gray-500 text-xs font-bold uppercase">User Aktif</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] ?? 0 }}</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    {{-- 2. GRAFIK PENGUNJUNG --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-gray-800 text-lg">Statistik 7 Hari Terakhir</h3>
            {{-- Tombol Tarik Berita API --}}
            <form action="{{ route('admin.sync') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-2 rounded-lg shadow transition">
                    <i class="fas fa-sync mr-1"></i> Sync NewsAPI
                </button>
            </form>
        </div>
        <div class="relative h-64 w-full">
            <canvas id="visitorChart"></canvas>
        </div>
        
        {{-- HIDDEN INPUTS UNTUK DATA CHART --}}
        <textarea id="chartDataLabels" class="hidden">{{ json_encode($chartData['labels'] ?? []) }}</textarea>
        <textarea id="chartDataValues" class="hidden">{{ json_encode($chartData['data'] ?? []) }}</textarea>
    </div>

    {{-- 3. LOG AKTIVITAS USER --}}
    <div class="bg-white rounded-xl shadow-sm p-6 overflow-hidden">
        <h3 class="font-bold text-gray-800 text-lg mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-4 max-h-64 overflow-y-auto custom-scroll pr-2">
            @forelse($userActivities as $act)
                <div class="flex items-start space-x-3 pb-3 border-b border-gray-100 last:border-0">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 flex-shrink-0">
                        {{ substr($act->user_name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-800">
                            <span class="font-bold">{{ $act->user_name }}</span>
                            {{ $act->action }}
                            <span class="text-blue-600 font-medium truncate block max-w-[150px]">{{ $act->target }}</span>
                        </p>
                        <span class="text-[10px] text-gray-400 flex items-center mt-1">
                            <i class="far fa-clock mr-1"></i> {{ $act->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center">Belum ada aktivitas.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- 4. TABEL VERIFIKASI BERITA (DRAFT) --}}
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-10">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-red-50">
        <div class="flex items-center space-x-2">
            <div class="bg-red-100 text-red-600 p-2 rounded-lg"><i class="fas fa-robot"></i></div>
            <div>
                <h3 class="font-bold text-gray-800 text-lg">Verifikasi AI & Draft</h3>
                <p class="text-xs text-gray-500">Menampilkan berita yang perlu review Admin</p>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-bold">
                <tr>
                    <th class="px-6 py-4">Berita</th>
                    <th class="px-6 py-4">AI Score</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pendingNews as $news)
                    <tr class="hover:bg-red-50/30 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                {{-- UPDATE: Ditambahkan onerror --}}
                                <img src="{{ $news->image }}" 
                                     class="w-16 h-12 object-cover rounded-lg shadow-sm mr-3"
                                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=600&auto=format&fit=crop';">
                                <div>
                                    <div class="font-bold text-gray-800 text-sm mb-1 line-clamp-1">{{ $news->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $news->source ?? 'Manual' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                @if($news->ai_trust_score < 50)
                                    <span class="text-red-600 font-bold text-xs">Risiko Tinggi ({{ $news->ai_trust_score }}%)</span>
                                    <span class="text-[10px] text-gray-500 line-clamp-1" title="{{ $news->ai_analysis }}">{{ $news->ai_analysis }}</span>
                                @else
                                    <span class="text-green-600 font-bold text-xs">Aman ({{ $news->ai_trust_score }}%)</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded bg-gray-100 text-xs text-gray-600 border">{{ $news->category }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center space-x-2">
                                {{-- REJECT FORM --}}
                                <form action="{{ route('admin.reject', $news->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?');">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition flex items-center justify-center">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                {{-- APPROVE FORM --}}
                                <form action="{{ route('admin.approve', $news->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 rounded-full bg-green-100 text-green-600 hover:bg-green-600 hover:text-white transition flex items-center justify-center">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500">Tidak ada berita pending.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Chart === 'undefined') {
            console.error('Chart.js belum dimuat.');
            return;
        }

        const canvas = document.getElementById('visitorChart');

        if (canvas) {
            const rawLabels = document.getElementById('chartDataLabels').value;
            const rawValues = document.getElementById('chartDataValues').value;
            
            let chartLabels = [];
            let chartValues = [];

            try {
                chartLabels = JSON.parse(rawLabels || '[]');
                chartValues = JSON.parse(rawValues || '[]');
            } catch (e) {
                console.error("Gagal parsing JSON grafik:", e);
            }

            new Chart(canvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Pengunjung',
                        data: chartValues,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { borderDash: [2, 4] },
                            ticks: { stepSize: 1 }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    });
</script>
@endsection