<?php

namespace App\Http\Controllers;

use App\Services\MasterDataService;
use App\Services\ShopService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly ShopService $shopService,
        private readonly MasterDataService $masterDataService,
    ) {}

    public function index(): View
    {
        $prefectures = $this->masterDataService->getPrefecturesWithAreas();
        $businessTypes = $this->masterDataService->getBusinessTypes();
        $featuredShops = $this->shopService->getFeaturedShops();
        $newShops = $this->shopService->getNewShops();

        return view('home.index', compact(
            'prefectures',
            'businessTypes',
            'featuredShops',
            'newShops'
        ));
    }
}
