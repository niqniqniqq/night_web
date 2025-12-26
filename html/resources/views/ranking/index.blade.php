@extends('layouts.app')

@section('title', 'ランキング')
@section('description', '関東エリアのキャバクラ・ガールズバー人気ランキング')

@section('content')
    <div class="bg-gray-800 py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold mb-4">ランキング</h1>

            <form action="{{ route('ranking') }}" method="GET" class="flex flex-wrap gap-4">
                <div>
                    <select name="prefecture"
                            class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-pink-500"
                            onchange="this.form.submit()">
                        <option value="">全エリア</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture->id }}" {{ request('prefecture') == $prefecture->id ? 'selected' : '' }}>
                                {{ $prefecture->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="type"
                            class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-pink-500"
                            onchange="this.form.submit()">
                        <option value="">全業種</option>
                        @foreach($businessTypes as $type)
                            <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <section class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-transparent bg-clip-text">
                        人気ランキング
                    </span>
                    <span class="ml-2 text-gray-400 text-sm font-normal">（閲覧数順）</span>
                </h2>

                @if($popularShops->count() > 0)
                    <div class="space-y-4">
                        @foreach($popularShops as $index => $shop)
                            <a href="{{ route('shop.show', $shop) }}"
                               class="flex items-center space-x-4 hover:bg-gray-700/50 p-3 rounded-lg transition group">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full font-bold
                                    {{ $index < 3 ? 'bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900' : 'bg-gray-700 text-gray-400' }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                    @if($shop->main_image)
                                        <img src="{{ asset('storage/' . $shop->main_image) }}"
                                             alt="{{ $shop->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold group-hover:text-pink-400 transition truncate">{{ $shop->name }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $shop->area->prefecture->name }} / {{ $shop->area->name }}</p>
                                </div>
                                <div class="text-right text-sm text-gray-400">
                                    {{ number_format($shop->view_count) }} views
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-center py-8">データがありません</p>
                @endif
            </section>

            <section class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <span class="bg-gradient-to-r from-pink-400 to-purple-500 text-transparent bg-clip-text">
                        評価ランキング
                    </span>
                    <span class="ml-2 text-gray-400 text-sm font-normal">（平均評価順）</span>
                </h2>

                @if($topRatedShops->count() > 0)
                    <div class="space-y-4">
                        @foreach($topRatedShops as $index => $shop)
                            <a href="{{ route('shop.show', $shop) }}"
                               class="flex items-center space-x-4 hover:bg-gray-700/50 p-3 rounded-lg transition group">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full font-bold
                                    {{ $index < 3 ? 'bg-gradient-to-r from-pink-400 to-purple-500 text-white' : 'bg-gray-700 text-gray-400' }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                    @if($shop->main_image)
                                        <img src="{{ asset('storage/' . $shop->main_image) }}"
                                             alt="{{ $shop->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold group-hover:text-pink-400 transition truncate">{{ $shop->name }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $shop->area->prefecture->name }} / {{ $shop->area->name }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center text-yellow-400">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="ml-1 font-semibold">{{ number_format($shop->reviews_avg_rating_overall, 1) }}</span>
                                    </div>
                                    <p class="text-gray-400 text-xs">{{ $shop->reviews_count }}件</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-center py-8">データがありません</p>
                @endif
            </section>

            <section class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <span class="bg-gradient-to-r from-green-400 to-cyan-500 text-transparent bg-clip-text">
                        口コミランキング
                    </span>
                    <span class="ml-2 text-gray-400 text-sm font-normal">（口コミ数順）</span>
                </h2>

                @if($mostReviewedShops->count() > 0)
                    <div class="space-y-4">
                        @foreach($mostReviewedShops as $index => $shop)
                            <a href="{{ route('shop.show', $shop) }}"
                               class="flex items-center space-x-4 hover:bg-gray-700/50 p-3 rounded-lg transition group">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full font-bold
                                    {{ $index < 3 ? 'bg-gradient-to-r from-green-400 to-cyan-500 text-gray-900' : 'bg-gray-700 text-gray-400' }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                    @if($shop->main_image)
                                        <img src="{{ asset('storage/' . $shop->main_image) }}"
                                             alt="{{ $shop->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold group-hover:text-pink-400 transition truncate">{{ $shop->name }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $shop->area->prefecture->name }} / {{ $shop->area->name }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-lg font-semibold text-cyan-400">{{ $shop->reviews_count }}</span>
                                    <span class="text-gray-400 text-sm">件</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-center py-8">データがありません</p>
                @endif
            </section>

            <section class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <span class="bg-gradient-to-r from-blue-400 to-indigo-500 text-transparent bg-clip-text">
                        新着店舗
                    </span>
                    <span class="ml-2 text-gray-400 text-sm font-normal">（登録順）</span>
                </h2>

                @if($newShops->count() > 0)
                    <div class="space-y-4">
                        @foreach($newShops as $index => $shop)
                            <a href="{{ route('shop.show', $shop) }}"
                               class="flex items-center space-x-4 hover:bg-gray-700/50 p-3 rounded-lg transition group">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full font-bold
                                    {{ $index < 3 ? 'bg-gradient-to-r from-blue-400 to-indigo-500 text-white' : 'bg-gray-700 text-gray-400' }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                    @if($shop->main_image)
                                        <img src="{{ asset('storage/' . $shop->main_image) }}"
                                             alt="{{ $shop->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold group-hover:text-pink-400 transition truncate">{{ $shop->name }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $shop->area->prefecture->name }} / {{ $shop->area->name }}</p>
                                </div>
                                <div class="text-right text-sm text-gray-400">
                                    {{ $shop->created_at->format('m/d') }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-center py-8">データがありません</p>
                @endif
            </section>
        </div>
    </div>
@endsection
