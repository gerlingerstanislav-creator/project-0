<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('scope', 20);
            $table->string('target_key', 64);
            $table->string('action', 30);
            $table->json('categories')->nullable();
            $table->json('sources')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'scope', 'target_key']);
            $table->index(['user_id', 'action']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_feedback');
    }
};
