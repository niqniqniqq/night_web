<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('casts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->string('profile_image')->nullable();
            $table->tinyInteger('age')->nullable();
            $table->smallInteger('height')->nullable();
            $table->enum('blood_type', ['A', 'B', 'O', 'AB'])->nullable();
            $table->string('birthplace', 50)->nullable();
            $table->string('hobby')->nullable();
            $table->string('special_skill')->nullable();
            $table->text('self_introduction')->nullable();
            $table->text('message')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['shop_id', 'slug']);
            $table->index(['shop_id', 'is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casts');
    }
};
