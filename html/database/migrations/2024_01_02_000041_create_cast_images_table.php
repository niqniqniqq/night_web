<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cast_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cast_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->enum('image_type', ['profile', 'gravure', 'other'])->default('profile');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['cast_id', 'image_type', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cast_images');
    }
};
