<?php

namespace App\Http\Controllers;

use App\Models\BusinessType;
use App\Models\Prefecture;
use App\Services\MasterDataService;
use App\Services\ShopService;
use Illuminate\View\View;

class GenreController extends Controller
{
    public function __construct(
        private readonly ShopService $shopService,
        private readonly MasterDataService $masterDataService,
    ) {}

    public function index(BusinessType $businessType): View
    {
        $prefectures = $this->masterDataService->getPrefecturesWithAreas();
        $shops = $this->shopService->getByBusinessType($businessType->id);

        return view('genre.index', compact('businessType', 'prefectures', 'shops'));
    }

    public function prefecture(BusinessType $businessType, Prefecture $prefecture): View
    {
        $areas = $prefecture->activeAreas()->get();
        $shops = $this->shopService->getByBusinessType($businessType->id, $prefecture->id);

        return view('genre.prefecture', compact('businessType', 'prefecture', 'areas', 'shops'));
    }
}
