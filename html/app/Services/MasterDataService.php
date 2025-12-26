<?php

namespace App\Services;

use App\Models\Area;
use App\Models\BusinessType;
use App\Models\Prefecture;
use Illuminate\Database\Eloquent\Collection;

class MasterDataService
{
    public function getPrefectures(): Collection
    {
        return Prefecture::active()
            ->ordered()
            ->get();
    }

    public function getPrefecturesWithAreas(): Collection
    {
        return Prefecture::active()
            ->ordered()
            ->with(['activeAreas'])
            ->get();
    }

    public function getBusinessTypes(): Collection
    {
        return BusinessType::active()
            ->ordered()
            ->get();
    }

    public function getAreasByPrefecture(int $prefectureId): Collection
    {
        return Area::where('prefecture_id', $prefectureId)
            ->active()
            ->ordered()
            ->get();
    }

    public function getAreasWithShopCount(Prefecture $prefecture): Collection
    {
        return $prefecture->activeAreas()
            ->withCount(['shops' => fn($q) => $q->published()])
            ->get();
    }
}
