<?php

namespace App\Http\Controllers;

use App\Services\MasterDataService;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RankingController extends Controller
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
            'type' => $request->input('type'),
        ];

        $popularShops = $this->shopService->getPopularRanking($filters);
        $topRatedShops = $this->shopService->getTopRatedRanking($filters);
        $mostReviewedShops = $this->shopService->getMostReviewedRanking($filters);
        $newShops = $this->shopService->getNewRanking($filters);

        return view('ranking.index', compact(
            'prefectures',
            'businessTypes',
            'popularShops',
            'topRatedShops',
            'mostReviewedShops',
            'newShops'
        ));
    }
}
