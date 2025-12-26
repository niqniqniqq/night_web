<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Services\CastService;
use App\Services\ReviewService;
use App\Services\ShopService;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function __construct(
        private readonly ShopService $shopService,
        private readonly CastService $castService,
        private readonly ReviewService $reviewService,
    ) {}

    public function show(Shop $shop): View
    {
        $shop = $this->shopService->getShopWithDetails($shop);
        $shop->incrementViewCount();

        $relatedShops = $this->shopService->getRelatedShops($shop);
        $averageRating = $this->shopService->getAverageRating($shop);

        return view('shop.show', compact('shop', 'relatedShops', 'averageRating'));
    }

    public function casts(Shop $shop): View
    {
        $shop->load(['area.prefecture']);
        $casts = $this->castService->getShopCasts($shop);

        return view('shop.casts', compact('shop', 'casts'));
    }

    public function reviews(Shop $shop): View
    {
        $shop->load(['area.prefecture']);

        $reviews = $this->reviewService->getShopReviews($shop);
        $averageRating = $this->reviewService->getAverageRating($shop);
        $ratingCounts = $this->reviewService->getRatingCounts($shop);

        return view('shop.reviews', compact('shop', 'reviews', 'averageRating', 'ratingCounts'));
    }
}
