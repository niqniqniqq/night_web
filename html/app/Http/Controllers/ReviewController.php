<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Shop;
use App\Services\ReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(
        private readonly ReviewService $reviewService,
    ) {}

    public function create(Shop $shop): View
    {
        $shop->load(['area.prefecture']);

        return view('review.create', compact('shop'));
    }

    public function store(StoreReviewRequest $request, Shop $shop): RedirectResponse
    {
        $this->reviewService->createReview($shop, $request->validated(), $request->ip());

        return redirect()
            ->route('shop.show', $shop)
            ->with('success', '口コミを投稿しました。管理者の承認後に公開されます。');
    }
}
