<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Services\CastService;
use Illuminate\View\View;

class CastController extends Controller
{
    public function __construct(
        private readonly CastService $castService,
    ) {}

    public function show(Cast $cast): View
    {
        $cast = $this->castService->getCastWithDetails($cast);
        $otherCasts = $this->castService->getOtherCasts($cast);

        return view('cast.show', compact('cast', 'otherCasts'));
    }
}
