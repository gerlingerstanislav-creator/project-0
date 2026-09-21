<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->json('categories');
            $table->float('min_importance')->default(0.45);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_preferences');
    }
};
