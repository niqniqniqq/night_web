@extends('layouts.app')

@section('title', $shop->name)
@section('description', $shop->catch_copy ?? $shop->name . 'の店舗情報')

@section('content')
    <nav class="bg-gray-800 py-3">
        <div class="container mx-auto px-4">
            <ol class="flex items-center text-sm text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-pink-400">TOP</a></li>
                <li class="mx-2">/</li>
                <li><a href="{{ route('area.prefecture', $shop->area->prefecture) }}" class="hover:text-pink-400">{{ $shop->area->prefecture->name }}</a></li>
                <li class="mx-2">/</li>
                <li><a href="{{ route('area.show', [$shop->area->prefecture, $shop->area]) }}" class="hover:text-pink-400">{{ $shop->area->name }}</a></li>
                <li class="mx-2">/</li>
                <li class="text-gray-200">{{ $shop->name }}</li>
            </ol>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-gray-800 rounded-lg overflow-hidden">
                    <div class="aspect-video relative">
                        @if($shop->main_image)
                            <img src="{{ asset('storage/' . $shop->main_image) }}"
                                 alt="{{ $shop->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        @if($shop->is_featured)
                            <span class="absolute top-4 left-4 bg-pink-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                おすすめ
                            </span>
                        @endif
                    </div>

                    <div class="p-6">
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($shop->businessTypes as $type)
                                <a href="{{ route('genre.index', $type) }}"
                                   class="bg-pink-500/20 text-pink-400 px-3 py-1 rounded-full text-sm hover:bg-pink-500/30 transition">
                                    {{ $type->name }}
                                </a>
                            @endforeach
                        </div>

                        <h1 class="text-3xl font-bold mb-2">{{ $shop->name }}</h1>

                        @if($shop->catch_copy)
                            <p class="text-xl text-pink-400 mb-4">{{ $shop->catch_copy }}</p>
                        @endif

                        <div class="flex items-center text-gray-400 text-sm space-x-4 mb-6">
                            <span>{{ $shop->area->prefecture->name }} / {{ $shop->area->name }}</span>
                            @if($shop->station)
                                <span>{{ $shop->station->name }}駅</span>
                            @endif
                            <span>{{ number_format($shop->view_count) }} views</span>
                        </div>

                        @if($shop->description)
                            <div class="prose prose-invert max-w-none mb-8">
                                {!! $shop->description !!}
                            </div>
                        @endif
                    </div>
                </div>

                @if($shop->images->count() > 0)
                    <div class="bg-gray-800 rounded-lg p-6 mt-6">
                        <h2 class="text-xl font-bold mb-4">店舗画像</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($shop->images as $image)
                                <div class="aspect-square rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                         alt="{{ $image->alt_text ?? $shop->name }}"
                                         class="w-full h-full object-cover hover:scale-105 transition cursor-pointer">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($shop->price_info || $shop->system_info)
                    <div class="bg-gray-800 rounded-lg p-6 mt-6">
                        @if($shop->price_info)
                            <h2 class="text-xl font-bold mb-4">料金情報</h2>
                            <div class="prose prose-invert max-w-none mb-6">
                                {!! $shop->price_info !!}
                            </div>
                        @endif

                        @if($shop->system_info)
                            <h2 class="text-xl font-bold mb-4">システム</h2>
                            <div class="prose prose-invert max-w-none">
                                {!! $shop->system_info !!}
                            </div>
                        @endif
                    </div>
                @endif

                @if($shop->castMembers->count() > 0)
                    <div class="bg-gray-800 rounded-lg p-6 mt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-bold">在籍キャスト</h2>
                            <a href="{{ route('shop.casts', $shop) }}"
                               class="text-pink-400 hover:text-pink-300 text-sm transition">
                                すべて見る →
                            </a>
                        </div>
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($shop->castMembers as $cast)
                                <a href="{{ route('cast.show', $cast) }}"
                                   class="group">
                                    <div class="aspect-[3/4] rounded-lg overflow-hidden mb-2">
                                        @if($cast->main_image)
                                            <img src="{{ asset('storage/' . $cast->main_image) }}"
                                                 alt="{{ $cast->name }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <p class="text-sm font-medium text-center group-hover:text-pink-400 transition truncate">
                                        {{ $cast->name }}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="bg-gray-800 rounded-lg p-6 mt-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <h2 class="text-xl font-bold">口コミ・評価</h2>
                            @if($averageRating)
                                <div class="flex items-center bg-gray-700 px-3 py-1 rounded">
                                    <svg class="w-5 h-5 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="font-semibold">{{ number_format($averageRating, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('shop.reviews', $shop) }}"
                               class="text-gray-400 hover:text-white text-sm transition">
                                すべて見る →
                            </a>
                            <a href="{{ route('review.create', $shop) }}"
                               class="bg-pink-500 hover:bg-pink-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                                口コミを投稿
                            </a>
                        </div>
                    </div>

                    @if($shop->reviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($shop->reviews as $review)
                                <div class="border-b border-gray-700 pb-4 last:border-0 last:pb-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium">{{ $review->nickname }}</span>
                                            <span class="text-gray-500 text-sm">{{ $review->created_at->format('Y/m/d') }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating_overall ? 'text-yellow-400' : 'text-gray-600' }}"
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <h4 class="font-medium mb-1">{{ $review->title }}</h4>
                                    <p class="text-gray-400 text-sm line-clamp-2">{{ $review->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-400 mb-4">まだ口コミがありません</p>
                            <a href="{{ route('review.create', $shop) }}"
                               class="inline-block bg-pink-500 hover:bg-pink-600 text-white font-semibold px-6 py-2 rounded-lg transition">
                                最初の口コミを投稿する
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-800 rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-4">店舗情報</h2>
                    <dl class="space-y-4">
                        @if($shop->phone)
                            <div>
                                <dt class="text-gray-400 text-sm">電話番号</dt>
                                <dd class="text-lg font-semibold">
                                    <a href="tel:{{ $shop->phone }}" class="text-pink-400 hover:text-pink-300">
                                        {{ $shop->phone }}
                                    </a>
                                </dd>
                            </div>
                        @endif

                        @if($shop->address)
                            <div>
                                <dt class="text-gray-400 text-sm">住所</dt>
                                <dd>
                                    {{ $shop->address }}
                                    @if($shop->building)
                                        <br>{{ $shop->building }}
                                    @endif
                                </dd>
                            </div>
                        @endif

                        @if($shop->access)
                            <div>
                                <dt class="text-gray-400 text-sm">アクセス</dt>
                                <dd class="whitespace-pre-line">{{ $shop->access }}</dd>
                            </div>
                        @endif

                        @if($shop->official_url)
                            <div>
                                <dt class="text-gray-400 text-sm">公式サイト</dt>
                                <dd>
                                    <a href="{{ $shop->official_url }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="text-pink-400 hover:text-pink-300 break-all">
                                        {{ $shop->official_url }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                @if($shop->schedules->count() > 0)
                    <div class="bg-gray-800 rounded-lg p-6">
                        <h2 class="text-xl font-bold mb-4">営業時間</h2>
                        <table class="w-full">
                            <tbody>
                                @foreach($shop->schedules as $schedule)
                                    <tr class="border-b border-gray-700 last:border-0">
                                        <td class="py-2 text-gray-400">{{ $schedule->day_name }}</td>
                                        <td class="py-2 text-right {{ $schedule->is_closed ? 'text-gray-500' : '' }}">
                                            {{ $schedule->formatted_time }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        @if($relatedShops->count() > 0)
            <section class="mt-12">
                <h2 class="text-2xl font-bold mb-6 flex items-center">
                    <span class="bg-pink-500 w-1 h-6 mr-3"></span>
                    {{ $shop->area->name }}の他の店舗
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedShops as $relatedShop)
                        <x-shop-card :shop="$relatedShop" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
