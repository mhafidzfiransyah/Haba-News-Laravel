<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Comment;
use App\Models\ActivityLog;

class BeritaController extends Controller
{
    public function show($id)
    {
        $news = News::with('comments')->findOrFail($id);

        // Increment views manual
        $news->views = $news->views + 1;
        $news->save();

        $relatedNews = News::where('category', $news->category)
                        ->where('status', 'published')
                        ->where('id', '!=', $id)
                        ->latest()
                        ->take(3)
                        ->get();

        $comments = $news->comments;

        return view('Berita.detail', compact('news', 'comments', 'relatedNews'));
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:500',
            'name' => 'required|string|max:50'
        ]);

        $news = News::findOrFail($id);

        // Simpan Komentar
        Comment::create([
            'news_id' => $id,
            'name' => $request->name,
            'text' => $request->text,
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($request->name) . '&background=random'
        ]);

        // PERBAIKAN: Simpan ke Activity Log
        // Pastikan model ActivityLog sudah di import di atas
        ActivityLog::create([
            'user_name' => $request->name, // Ambil nama dari input form
            'action' => 'Mengomentari berita',
            'target' => substr($news->title, 0, 30) . '...', // Potong judul biar ga kepanjangan
            'type' => 'comment'
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil dikirim!');
    }
}