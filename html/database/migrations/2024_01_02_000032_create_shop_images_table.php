<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->enum('image_type', ['main', 'interior', 'exterior', 'menu'])->default('main');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['shop_id', 'image_type', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_images');
    }
};
