<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cast_blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cast_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->string('thumbnail')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['cast_id', 'slug']);
            $table->index(['cast_id', 'is_published', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cast_blogs');
    }
};
