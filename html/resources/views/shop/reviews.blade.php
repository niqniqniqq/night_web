@extends('layouts.app')

@section('title', $shop->name . 'の口コミ・評価')
@section('description', $shop->name . 'の口コミ・レビュー一覧です')

@section('content')
    <nav class="bg-gray-800 py-3">
        <div class="container mx-auto px-4">
            <ol class="flex items-center text-sm text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-pink-400">TOP</a></li>
                <li class="mx-2">/</li>
                <li><a href="{{ route('area.prefecture', $shop->area->prefecture) }}" class="hover:text-pink-400">{{ $shop->area->prefecture->name }}</a></li>
                <li class="mx-2">/</li>
                <li><a href="{{ route('shop.show', $shop) }}" class="hover:text-pink-400">{{ $shop->name }}</a></li>
                <li class="mx-2">/</li>
                <li class="text-gray-200">口コミ</li>
            </ol>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold">口コミ・評価</h1>
                <p class="text-gray-400 mt-2">{{ $shop->name }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('shop.show', $shop) }}"
                   class="text-gray-400 hover:text-white transition flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    店舗情報
                </a>
                <a href="{{ route('review.create', $shop) }}"
                   class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-6 py-2 rounded-lg transition">
                    口コミを投稿
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-gray-800 rounded-lg p-6 sticky top-4">
                    <h2 class="text-lg font-semibold mb-4">評価サマリー</h2>

                    @if($averageRating)
                        <div class="text-center mb-6">
                            <div class="text-5xl font-bold text-pink-400">{{ number_format($averageRating, 1) }}</div>
                            <div class="flex justify-center mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-600' }}"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-gray-400 text-sm mt-1">{{ $reviews->total() }}件の口コミ</p>
                        </div>

                        <div class="space-y-2">
                            @for($rating = 5; $rating >= 1; $rating--)
                                @php
                                    $count = $ratingCounts[$rating] ?? 0;
                                    $percentage = $reviews->total() > 0 ? ($count / $reviews->total()) * 100 : 0;
                                @endphp
                                <div class="flex items-center text-sm">
                                    <span class="w-8">{{ $rating }}</span>
                                    <svg class="w-4 h-4 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <div class="flex-1 bg-gray-700 rounded-full h-2 mr-2">
                                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-gray-400 w-8 text-right">{{ $count }}</span>
                                </div>
                            @endfor
                        </div>
                    @else
                        <div class="text-center text-gray-400 py-4">
                            <p>まだ口コミがありません</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-3">
                @if($reviews->count() > 0)
                    <div class="space-y-6">
                        @foreach($reviews as $review)
                            <div class="bg-gray-800 rounded-lg p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <span class="font-semibold">{{ $review->nickname }}</span>
                                            @if($review->is_featured)
                                                <span class="bg-pink-500/20 text-pink-400 text-xs px-2 py-0.5 rounded">おすすめ</span>
                                            @endif
                                        </div>
                                        <div class="text-gray-400 text-sm mt-1">
                                            {{ $review->created_at->format('Y年m月d日') }}
                                            @if($review->visit_date)
                                                <span class="ml-2">来店: {{ $review->visit_date->format('Y年m月') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center bg-gray-700 px-3 py-1 rounded">
                                        <svg class="w-5 h-5 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="font-semibold">{{ $review->rating_overall }}</span>
                                    </div>
                                </div>

                                <h3 class="text-lg font-semibold mb-2">{{ $review->title }}</h3>
                                <p class="text-gray-300 whitespace-pre-line">{{ $review->content }}</p>

                                <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-gray-700">
                                    <div class="text-center">
                                        <div class="text-gray-400 text-xs">接客</div>
                                        <div class="flex justify-center mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating_service ? 'text-yellow-400' : 'text-gray-600' }}"
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-gray-400 text-xs">雰囲気</div>
                                        <div class="flex justify-center mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating_atmosphere ? 'text-yellow-400' : 'text-gray-600' }}"
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-gray-400 text-xs">コスパ</div>
                                        <div class="flex justify-center mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating_cost_performance ? 'text-yellow-400' : 'text-gray-600' }}"
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="bg-gray-800 rounded-lg p-12 text-center">
                        <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-gray-400 mb-4">まだ口コミがありません</p>
                        <a href="{{ route('review.create', $shop) }}"
                           class="inline-block bg-pink-500 hover:bg-pink-600 text-white font-semibold px-6 py-2 rounded-lg transition">
                            最初の口コミを投稿する
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
