<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nickname', 50);
            $table->string('title');
            $table->text('content');
            $table->tinyInteger('rating_overall')->default(3);
            $table->tinyInteger('rating_service')->default(3);
            $table->tinyInteger('rating_atmosphere')->default(3);
            $table->tinyInteger('rating_cost_performance')->default(3);
            $table->date('visit_date')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('helpful_count')->default(0);
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['shop_id', 'is_approved']);
            $table->index(['is_approved', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
