<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('day_of_week'); // 0=日, 1=月, ..., 6=土
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->string('note')->nullable();
            $table->timestamps();

            $table->unique(['shop_id', 'day_of_week']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_schedules');
    }
};
