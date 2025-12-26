<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Shop;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReviewService
{
    public function createReview(Shop $shop, array $data, ?string $ipAddress = null): Review
    {
        return Review::create([
            'shop_id' => $shop->id,
            'nickname' => $data['nickname'],
            'title' => $data['title'],
            'content' => $data['content'],
            'rating_overall' => $data['rating_overall'],
            'rating_service' => $data['rating_service'],
            'rating_atmosphere' => $data['rating_atmosphere'],
            'rating_cost_performance' => $data['rating_cost_performance'],
            'visit_date' => $data['visit_date'] ?? null,
            'ip_address' => $ipAddress,
            'is_approved' => false,
        ]);
    }

    public function getShopReviews(Shop $shop, int $perPage = 10): LengthAwarePaginator
    {
        return $shop->reviews()
            ->approved()
            ->latest()
            ->paginate($perPage);
    }

    public function getAverageRating(Shop $shop): ?float
    {
        return $shop->reviews()->approved()->avg('rating_overall');
    }

    public function getRatingCounts(Shop $shop): array
    {
        return $shop->reviews()
            ->approved()
            ->selectRaw('rating_overall, COUNT(*) as count')
            ->groupBy('rating_overall')
            ->orderBy('rating_overall', 'desc')
            ->pluck('count', 'rating_overall')
            ->toArray();
    }
}
