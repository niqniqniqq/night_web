<?php

namespace App\Services;

use App\Models\Shop;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ShopService
{
    private function baseQuery(): Builder
    {
        return Shop::published()
            ->with(['area.prefecture', 'businessTypes', 'images']);
    }

    public function getFeaturedShops(int $limit = 6): Collection
    {
        return $this->baseQuery()
            ->featured()
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getNewShops(int $limit = 6): Collection
    {
        return $this->baseQuery()
            ->latest()
            ->take($limit)
            ->get();
    }

    public function search(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        $query = $this->baseQuery();

        $this->applyFilters($query, $filters);
        $this->applySort($query, $filters['sort'] ?? 'new');

        return $query->paginate($perPage)->withQueryString();
    }

    public function getByPrefecture(int $prefectureId, ?int $businessTypeId = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = Shop::published()
            ->whereHas('area', fn($q) => $q->where('prefecture_id', $prefectureId))
            ->with(['area', 'businessTypes', 'images']);

        if ($businessTypeId) {
            $query->withBusinessType($businessTypeId);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getByArea(int $areaId, ?int $businessTypeId = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = Shop::published()
            ->where('area_id', $areaId)
            ->with(['area', 'businessTypes', 'station', 'images']);

        if ($businessTypeId) {
            $query->withBusinessType($businessTypeId);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getByBusinessType(int $businessTypeId, ?int $prefectureId = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = Shop::published()
            ->withBusinessType($businessTypeId)
            ->with(['area.prefecture', 'businessTypes', 'images']);

        if ($prefectureId) {
            $query->whereHas('area', fn($q) => $q->where('prefecture_id', $prefectureId));
        }

        return $query->latest()->paginate($perPage);
    }

    public function getPopularRanking(array $filters = [], int $limit = 10): Collection
    {
        return $this->buildRankingQuery($filters)
            ->orderByDesc('view_count')
            ->take($limit)
            ->get();
    }

    public function getTopRatedRanking(array $filters = [], int $limit = 10): Collection
    {
        return $this->buildRankingQuery($filters)
            ->withAvg(['reviews' => fn($q) => $q->where('is_approved', true)], 'rating_overall')
            ->withCount(['reviews' => fn($q) => $q->where('is_approved', true)])
            ->having('reviews_count', '>=', 1)
            ->orderByDesc('reviews_avg_rating_overall')
            ->take($limit)
            ->get();
    }

    public function getMostReviewedRanking(array $filters = [], int $limit = 10): Collection
    {
        return $this->buildRankingQuery($filters)
            ->withCount(['reviews' => fn($q) => $q->where('is_approved', true)])
            ->having('reviews_count', '>=', 1)
            ->orderByDesc('reviews_count')
            ->take($limit)
            ->get();
    }

    public function getNewRanking(array $filters = [], int $limit = 10): Collection
    {
        return $this->buildRankingQuery($filters)
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getRelatedShops(Shop $shop, int $limit = 4): Collection
    {
        return Shop::published()
            ->where('id', '!=', $shop->id)
            ->where('area_id', $shop->area_id)
            ->with(['businessTypes', 'images', 'area.prefecture'])
            ->take($limit)
            ->get();
    }

    public function getShopWithDetails(Shop $shop): Shop
    {
        $shop->load([
            'area.prefecture',
            'station',
            'businessTypes',
            'images',
            'schedules',
            'castMembers' => fn($query) => $query->active()->with('images')->take(8),
            'reviews' => fn($query) => $query->approved()->latest()->take(3),
        ]);

        return $shop;
    }

    public function getAverageRating(Shop $shop): ?float
    {
        return $shop->reviews()->approved()->avg('rating_overall');
    }

    private function buildRankingQuery(array $filters): Builder
    {
        $query = $this->baseQuery();

        if (!empty($filters['prefecture'])) {
            $query->whereHas('area', fn($q) => $q->where('prefecture_id', $filters['prefecture']));
        }

        if (!empty($filters['type'])) {
            $query->withBusinessType($filters['type']);
        }

        return $query;
    }

    private function applyFilters(Builder $query, array $filters): void
    {
        if (!empty($filters['prefecture'])) {
            $query->whereHas('area', fn($q) => $q->where('prefecture_id', $filters['prefecture']));
        }

        if (!empty($filters['area'])) {
            $query->where('area_id', $filters['area']);
        }

        if (!empty($filters['type'])) {
            $query->withBusinessType($filters['type']);
        }

        if (!empty($filters['q'])) {
            $keyword = $filters['q'];
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('catch_copy', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if (!empty($filters['featured'])) {
            $query->featured();
        }
    }

    private function applySort(Builder $query, string $sort): void
    {
        switch ($sort) {
            case 'popular':
                $query->orderByDesc('view_count');
                break;
            case 'rating':
                $query->withAvg(['reviews' => fn($q) => $q->where('is_approved', true)], 'rating_overall')
                    ->orderByDesc('reviews_avg_rating_overall');
                break;
            case 'review_count':
                $query->withCount(['reviews' => fn($q) => $q->where('is_approved', true)])
                    ->orderByDesc('reviews_count');
                break;
            case 'new':
            default:
                $query->latest();
                break;
        }
    }
}
