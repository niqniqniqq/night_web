<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Prefecture;
use App\Services\MasterDataService;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AreaController extends Controller
{
    public function __construct(
        private readonly ShopService $shopService,
        private readonly MasterDataService $masterDataService,
    ) {}

    public function prefecture(Prefecture $prefecture, Request $request): View
    {
        $businessTypes = $this->masterDataService->getBusinessTypes();
        $selectedType = $request->query('type');

        $shops = $this->shopService->getByPrefecture(
            $prefecture->id,
            $selectedType ? (int) $selectedType : null
        );

        $areas = $this->masterDataService->getAreasWithShopCount($prefecture);

        return view('area.prefecture', compact(
            'prefecture',
            'shops',
            'areas',
            'businessTypes',
            'selectedType'
        ));
    }

    public function show(Prefecture $prefecture, Area $area, Request $request): View
    {
        $businessTypes = $this->masterDataService->getBusinessTypes();
        $selectedType = $request->query('type');

        $shops = $this->shopService->getByArea(
            $area->id,
            $selectedType ? (int) $selectedType : null
        );

        return view('area.show', compact(
            'prefecture',
            'area',
            'shops',
            'businessTypes',
            'selectedType'
        ));
    }
}
