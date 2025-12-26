<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CastBlogController;
use App\Http\Controllers\CastController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// トップページ
Route::get('/', [HomeController::class, 'index'])->name('home');

// 検索
Route::get('/search', [SearchController::class, 'index'])->name('search');

// ランキング
Route::get('/ranking', [RankingController::class, 'index'])->name('ranking');

// 地域別
Route::prefix('area')->group(function () {
    Route::get('/{prefecture:slug}', [AreaController::class, 'prefecture'])->name('area.prefecture');
    Route::get('/{prefecture:slug}/{area:slug}', [AreaController::class, 'show'])->name('area.show');
});

// 業種別
Route::prefix('genre')->group(function () {
    Route::get('/{businessType:slug}', [GenreController::class, 'index'])->name('genre.index');
    Route::get('/{businessType:slug}/{prefecture:slug}', [GenreController::class, 'prefecture'])->name('genre.prefecture');
});

// 店舗
Route::prefix('shop')->group(function () {
    Route::get('/{shop:slug}', [ShopController::class, 'show'])->name('shop.show');
    Route::get('/{shop:slug}/casts', [ShopController::class, 'casts'])->name('shop.casts');
    Route::get('/{shop:slug}/reviews', [ShopController::class, 'reviews'])->name('shop.reviews');
    Route::get('/{shop:slug}/review/new', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/{shop:slug}/review', [ReviewController::class, 'store'])->name('review.store');
});

// キャスト
Route::prefix('cast')->group(function () {
    Route::get('/{cast:slug}', [CastController::class, 'show'])->name('cast.show');
    Route::get('/{cast:slug}/blogs', [CastBlogController::class, 'index'])->name('cast.blogs');
    Route::get('/{cast:slug}/blog/{blog:slug}', [CastBlogController::class, 'show'])->name('cast.blog.show');
});
