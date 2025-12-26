<?php

namespace App\Services;

use App\Models\Cast;
use App\Models\CastBlog;
use App\Models\Shop;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CastService
{
    public function getCastWithDetails(Cast $cast): Cast
    {
        $cast->load(['shop.area.prefecture', 'images']);
        return $cast;
    }

    public function getOtherCasts(Cast $cast, int $limit = 4): Collection
    {
        return Cast::active()
            ->where('id', '!=', $cast->id)
            ->where('shop_id', $cast->shop_id)
            ->with(['images'])
            ->ordered()
            ->take($limit)
            ->get();
    }

    public function getShopCasts(Shop $shop, int $perPage = 12): LengthAwarePaginator
    {
        return $shop->castMembers()
            ->active()
            ->with(['images'])
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function getCastBlogs(Cast $cast, int $perPage = 12): LengthAwarePaginator
    {
        return $cast->publishedBlogs()
            ->paginate($perPage);
    }

    public function getBlogWithDetails(CastBlog $blog): CastBlog
    {
        $blog->load(['cast.shop.area.prefecture', 'cast.images']);
        return $blog;
    }

    public function getRecentBlogs(Cast $cast, int $excludeBlogId, int $limit = 4): Collection
    {
        return CastBlog::published()
            ->where('id', '!=', $excludeBlogId)
            ->where('cast_id', $cast->id)
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    public function incrementBlogViewCount(CastBlog $blog): void
    {
        $blog->incrementViewCount();
    }
}
