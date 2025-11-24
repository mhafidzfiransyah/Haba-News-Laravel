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
            'name' => 'HabaAdmin',
            'email' => 'haba@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
    }
}