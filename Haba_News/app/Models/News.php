<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke Komentar
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // Scope untuk berita yang sudah Approved/Published
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
    
    // Scope untuk pencarian
    public function scopeFilter($query, array $filters)
    {
        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('desc', 'like', '%' . $filters['search'] . '%');
        }

        if($filters['category'] ?? false) {
            $query->where('category', 'like', '%' . $filters['category'] . '%');
        }
    }
}