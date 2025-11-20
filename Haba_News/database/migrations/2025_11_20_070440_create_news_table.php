<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('desc')->nullable();
            $table->longText('content')->nullable();
            
            // PERUBAHAN DISINI: Ganti string() jadi text()
            $table->text('image')->nullable(); 
            
            $table->string('category');
            $table->string('author')->default('Admin');
            $table->string('source')->nullable();
            $table->enum('status', ['draft', 'published', 'rejected'])->default('draft');
            
            $table->boolean('is_verified')->default(false);
            $table->integer('ai_trust_score')->default(0); 
            $table->string('ai_analysis')->nullable();
            
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('is_hot')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};