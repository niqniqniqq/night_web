@extends('layouts.app')

@section('title', $cast->name . ' | ' . $cast->shop->name)
@section('description', $cast->self_introduction ?? $cast->name . 'のプロフィール')

@section('content')
    <nav class="bg-gray-800 py-3">
        <div class="container mx-auto px-4">
            <ol class="flex items-center text-sm text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-pink-400">TOP</a></li>
                <li class="mx-2">/</li>
                <li><a href="{{ route('area.prefecture', $cast->shop->area->prefecture) }}" class="hover:text-pink-400">{{ $cast->shop->area->prefecture->name }}</a></li>
                <li class="mx-2">/</li>
                <li><a href="{{ route('shop.show', $cast->shop) }}" class="hover:text-pink-400">{{ $cast->shop->name }}</a></li>
                <li class="mx-2">/</li>
                <li class="text-gray-200">{{ $cast->name }}</li>
            </ol>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-gray-800 rounded-lg overflow-hidden sticky top-4">
                    <div class="aspect-[3/4] relative">
                        @if($cast->main_image)
                            <img src="{{ asset('storage/' . $cast->main_image) }}"
                                 alt="{{ $cast->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif

                        @if($cast->is_featured)
                            <span class="absolute top-4 left-4 bg-pink-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                おすすめ
                            </span>
                        @endif
                    </div>

                    <div class="p-6">
                        <h1 class="text-2xl font-bold mb-2">{{ $cast->name }}</h1>
                        <a href="{{ route('shop.show', $cast->shop) }}"
                           class="text-pink-400 hover:text-pink-300 transition">
                            {{ $cast->shop->name }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-gray-800 rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-4">プロフィール</h2>

                    <dl class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @if($cast->age)
                            <div class="bg-gray-700/50 p-3 rounded-lg">
                                <dt class="text-gray-400 text-sm">年齢</dt>
                                <dd class="text-lg font-semibold">{{ $cast->age }}歳</dd>
                            </div>
                        @endif
                        @if($cast->height)
                            <div class="bg-gray-700/50 p-3 rounded-lg">
                                <dt class="text-gray-400 text-sm">身長</dt>
                                <dd class="text-lg font-semibold">{{ $cast->height }}cm</dd>
                            </div>
                        @endif
                        @if($cast->blood_type)
                            <div class="bg-gray-700/50 p-3 rounded-lg">
                                <dt class="text-gray-400 text-sm">血液型</dt>
                                <dd class="text-lg font-semibold">{{ $cast->blood_type }}型</dd>
                            </div>
                        @endif
                        @if($cast->birthplace)
                            <div class="bg-gray-700/50 p-3 rounded-lg">
                                <dt class="text-gray-400 text-sm">出身地</dt>
                                <dd class="text-lg font-semibold">{{ $cast->birthplace }}</dd>
                            </div>
                        @endif
                    </dl>

                    @if($cast->hobby || $cast->special_skill)
                        <div class="mt-6 space-y-4">
                            @if($cast->hobby)
                                <div>
                                    <dt class="text-gray-400 text-sm mb-1">趣味</dt>
                                    <dd>{{ $cast->hobby }}</dd>
                                </div>
                            @endif
                            @if($cast->special_skill)
                                <div>
                                    <dt class="text-gray-400 text-sm mb-1">特技</dt>
                                    <dd>{{ $cast->special_skill }}</dd>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @if($cast->self_introduction)
                    <div class="bg-gray-800 rounded-lg p-6">
                        <h2 class="text-xl font-bold mb-4">自己紹介</h2>
                        <p class="text-gray-300 whitespace-pre-line">{{ $cast->self_introduction }}</p>
                    </div>
                @endif

                @if($cast->message)
                    <div class="bg-gradient-to-r from-pink-500/20 to-purple-500/20 rounded-lg p-6">
                        <h2 class="text-xl font-bold mb-4">メッセージ</h2>
                        <p class="text-gray-300 whitespace-pre-line">{{ $cast->message }}</p>
                    </div>
                @endif

                @if($cast->images->count() > 0)
                    <div class="bg-gray-800 rounded-lg p-6">
                        <h2 class="text-xl font-bold mb-4">ギャラリー</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($cast->images as $image)
                                <div class="aspect-[3/4] rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                         alt="{{ $image->alt_text ?? $cast->name }}"
                                         class="w-full h-full object-cover hover:scale-105 transition cursor-pointer">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="bg-gray-800 rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-4">店舗情報</h2>
                    <div class="flex items-start space-x-4">
                        @if($cast->shop->main_image)
                            <img src="{{ asset('storage/' . $cast->shop->main_image) }}"
                                 alt="{{ $cast->shop->name }}"
                                 class="w-24 h-24 object-cover rounded-lg">
                        @else
                            <div class="w-24 h-24 bg-gray-700 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="font-bold text-lg">
                                <a href="{{ route('shop.show', $cast->shop) }}"
                                   class="hover:text-pink-400 transition">
                                    {{ $cast->shop->name }}
                                </a>
                            </h3>
                            <p class="text-gray-400 text-sm mt-1">
                                {{ $cast->shop->area->prefecture->name }} / {{ $cast->shop->area->name }}
                            </p>
                            @if($cast->shop->phone)
                                <p class="text-pink-400 mt-2">
                                    <a href="tel:{{ $cast->shop->phone }}">{{ $cast->shop->phone }}</a>
                                </p>
                            @endif
                        </div>
                        <a href="{{ route('shop.show', $cast->shop) }}"
                           class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded-lg transition whitespace-nowrap">
                            店舗詳細
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if($otherCasts->count() > 0)
            <section class="mt-12">
                <h2 class="text-2xl font-bold mb-6 flex items-center">
                    <span class="bg-pink-500 w-1 h-6 mr-3"></span>
                    {{ $cast->shop->name }}の他のキャスト
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($otherCasts as $otherCast)
                        <a href="{{ route('cast.show', $otherCast) }}"
                           class="bg-gray-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-pink-500 transition group">
                            <div class="aspect-[3/4] relative overflow-hidden">
                                @if($otherCast->main_image)
                                    <img src="{{ asset('storage/' . $otherCast->main_image) }}"
                                         alt="{{ $otherCast->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold group-hover:text-pink-400 transition">{{ $otherCast->name }}</h3>
                                <div class="text-gray-400 text-sm mt-1">
                                    @if($otherCast->age)
                                        {{ $otherCast->age }}歳
                                    @endif
                                    @if($otherCast->height)
                                        / {{ $otherCast->height }}cm
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
