<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Visitor;
use App\Models\User;
use App\Models\ActivityLog;
use App\Services\NewsService;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistik
        $stats = [
            'total_news' => News::count(),
            'total_visitors' => Visitor::count(),
            'total_users' => User::count(),
            'pending_reports' => News::where('status', 'draft')->count()
        ];

        // Grafik
        $labels = [];
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            $data[] = Visitor::whereDate('visit_date', $date->toDateString())->count();
        }
        $chartData = ['labels' => $labels, 'data' => $data];

        // Berita Draft (Pending)
        $pendingNews = News::where('status', 'draft')
            ->orderBy('ai_trust_score', 'asc')
            ->get();

        // Log User
        $userActivities = ActivityLog::latest()->take(5)->get();

        return view('Admin.dashboard', compact('stats', 'chartData', 'pendingNews', 'userActivities'));
    }

    public function syncNews(NewsService $newsService)
    {
        $message = $newsService->fetchFromExternalSource();
        return redirect()->back()->with('success', $message);
    }

    public function approveNews($id)
    {
        $news = News::findOrFail($id);
        $news->update([
            'status' => 'published',
            'is_verified' => true
        ]);

        ActivityLog::create([
            'user_name' => 'Admin',
            'action' => 'Menyetujui Berita',
            'target' => substr($news->title, 0, 30),
            'type' => 'approve'
        ]);

        return redirect()->back()->with('success', 'Berita berhasil dipublish.');
    }

    public function rejectNews($id)
    {
        $news = News::findOrFail($id);
        $title = $news->title;
        $news->delete();

        ActivityLog::create([
            'user_name' => 'Admin',
            'action' => 'Menghapus Berita',
            'target' => substr($title, 0, 30),
            'type' => 'delete'
        ]);

        return redirect()->back()->with('success', 'Berita berhasil dihapus permanen.');
    }

    public function berita(Request $request)
    {
        $query = News::latest();
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $allNews = $query->paginate(10);
        return view('Admin.berita.kelola', compact('allNews'));
    }

    // --- FUNGSI BARU: Hapus SEMUA Berita (Dipanggil dari halaman Kelola Berita) ---
    public function deleteAllContent()
    {
        // Hitung jumlah untuk log
        $count = News::count();

        // Hapus semua data
        News::query()->delete(); 
        // Note: query()->delete() lebih aman dibanding truncate() jika ada foreign key constraint

        // Catat Log
        ActivityLog::create([
            'user_name' => 'Admin',
            'action' => 'Menghapus SEMUA Berita',
            'target' => $count . ' items dibersihkan',
            'type' => 'delete'
        ]);

        return redirect()->back()->with('success', 'Database berita berhasil dikosongkan.');
    }

    // --- FUNGSI LAMA: Hapus Draft Only (Dipanggil dari Dashboard) ---
    public function deleteAllNews()
    {
        $pendingNews = News::where('status', '!=', 'published')->get();
        foreach ($pendingNews as $news) {
            $news->delete();
        }
        
        ActivityLog::create([
            'user_name' => 'Admin',
            'action' => 'Membersihkan Draft',
            'target' => 'Semua draft dihapus',
            'type' => 'delete'
        ]);

        return redirect()->back()->with('success', 'Semua berita pending berhasil dihapus.');
    }

    // -- USER MANAGEMENT --
    public function users(Request $request)
    {
        $users = User::latest()->paginate(10);
        return view('Admin.users.index', compact('users'));
    }

    public function usersShow($id)
    {
        $user = User::findOrFail($id);
        return view('Admin.users.show', compact('user'));
    }

    public function usersDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function userActivity($id)
    {
        return "Detail aktivitas user ID: " . $id;
    }
}