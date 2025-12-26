<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained()->cascadeOnDelete();
            $table->foreignId('station_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('catch_copy')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('address')->nullable();
            $table->string('building')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('access')->nullable();
            $table->text('price_info')->nullable();
            $table->text('system_info')->nullable();
            $table->string('official_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['area_id', 'is_active']);
            $table->index(['is_active', 'is_featured']);
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
