@extends('layouts.app')

@section('title', $shop->name . 'のキャスト一覧')
@section('description', $shop->name . 'に在籍するキャスト一覧です')

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
                <li class="text-gray-200">キャスト一覧</li>
            </ol>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">キャスト一覧</h1>
                <p class="text-gray-400 mt-2">{{ $shop->name }}</p>
            </div>
            <a href="{{ route('shop.show', $shop) }}"
               class="text-pink-400 hover:text-pink-300 transition flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                店舗情報に戻る
            </a>
        </div>

        @if($casts->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($casts as $cast)
                    <a href="{{ route('cast.show', $cast) }}"
                       class="bg-gray-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-pink-500 transition group">
                        <div class="aspect-[3/4] relative overflow-hidden">
                            @if($cast->main_image)
                                <img src="{{ asset('storage/' . $cast->main_image) }}"
                                     alt="{{ $cast->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif

                            @if($cast->is_featured)
                                <span class="absolute top-2 left-2 bg-pink-500 text-white text-xs px-2 py-1 rounded">
                                    おすすめ
                                </span>
                            @endif
                        </div>

                        <div class="p-4">
                            <h3 class="font-bold text-lg group-hover:text-pink-400 transition">{{ $cast->name }}</h3>
                            <div class="text-gray-400 text-sm mt-1 space-x-2">
                                @if($cast->age)
                                    <span>{{ $cast->age }}歳</span>
                                @endif
                                @if($cast->height)
                                    <span>{{ $cast->height }}cm</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $casts->links() }}
            </div>
        @else
            <div class="bg-gray-800 rounded-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-gray-400">キャスト情報はまだ登録されていません</p>
            </div>
        @endif
    </div>
@endsection
