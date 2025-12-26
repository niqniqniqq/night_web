<?php

namespace App\Http\Controllers;

use App\Services\MasterDataService;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(
        private readonly ShopService $shopService,
        private readonly MasterDataService $masterDataService,
    ) {}

    public function index(Request $request): View
    {
        $prefectures = $this->masterDataService->getPrefectures();
        $businessTypes = $this->masterDataService->getBusinessTypes();

        $filters = [
            'prefecture' => $request->input('prefecture'),
            'area' => $request->input('area'),
            'type' => $request->input('type'),
            'q' => $request->input('q'),
            'featured' => $request->boolean('featured'),
            'sort' => $request->input('sort', 'new'),
        ];

        $shops = $this->shopService->search($filters);

        $areas = collect();
        if ($request->filled('prefecture')) {
            $areas = $this->masterDataService->getAreasByPrefecture($request->prefecture);
        }

        return view('search.index', compact(
            'shops',
            'prefectures',
            'areas',
            'businessTypes'
        ));
    }
}
