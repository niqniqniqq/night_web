@extends('layouts.app')

@section('title', $cast->name . 'のブログ')
@section('description', $cast->name . 'のブログ一覧です')

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
                <li><a href="{{ route('cast.show', $cast) }}" class="hover:text-pink-400">{{ $cast->name }}</a></li>
                <li class="mx-2">/</li>
                <li class="text-gray-200">ブログ</li>
            </ol>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div class="flex items-center space-x-4">
                @if($cast->main_image)
                    <img src="{{ asset('storage/' . $cast->main_image) }}"
                         alt="{{ $cast->name }}"
                         class="w-16 h-16 rounded-full object-cover">
                @else
                    <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                @endif
                <div>
                    <h1 class="text-2xl font-bold">{{ $cast->name }}のブログ</h1>
                    <a href="{{ route('shop.show', $cast->shop) }}"
                       class="text-gray-400 hover:text-pink-400 transition text-sm">
                        {{ $cast->shop->name }}
                    </a>
                </div>
            </div>
            <a href="{{ route('cast.show', $cast) }}"
               class="text-pink-400 hover:text-pink-300 transition flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                プロフィールに戻る
            </a>
        </div>

        @if($blogs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($blogs as $blog)
                    <a href="{{ route('cast.blog.show', [$cast, $blog]) }}"
                       class="bg-gray-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-pink-500 transition group">
                        <div class="aspect-video relative overflow-hidden">
                            @if($blog->thumbnail)
                                <img src="{{ asset('storage/' . $blog->thumbnail) }}"
                                     alt="{{ $blog->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <p class="text-gray-400 text-sm mb-2">
                                {{ $blog->published_at->format('Y年m月d日') }}
                            </p>
                            <h3 class="font-bold group-hover:text-pink-400 transition line-clamp-2">
                                {{ $blog->title }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $blogs->links() }}
            </div>
        @else
            <div class="bg-gray-800 rounded-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <p class="text-gray-400">ブログ記事はまだありません</p>
            </div>
        @endif
    </div>
@endsection
