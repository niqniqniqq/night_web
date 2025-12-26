@extends('layouts.app')

@section('title', $blog->title . ' | ' . $cast->name)
@section('description', Str::limit(strip_tags($blog->content), 160))

@section('content')
    <nav class="bg-gray-800 py-3">
        <div class="container mx-auto px-4">
            <ol class="flex items-center text-sm text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-pink-400">TOP</a></li>
                <li class="mx-2">/</li>
                <li><a href="{{ route('shop.show', $cast->shop) }}" class="hover:text-pink-400">{{ $cast->shop->name }}</a></li>
                <li class="mx-2">/</li>
                <li><a href="{{ route('cast.show', $cast) }}" class="hover:text-pink-400">{{ $cast->name }}</a></li>
                <li class="mx-2">/</li>
                <li><a href="{{ route('cast.blogs', $cast) }}" class="hover:text-pink-400">ブログ</a></li>
                <li class="mx-2">/</li>
                <li class="text-gray-200 truncate max-w-xs">{{ $blog->title }}</li>
            </ol>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-3">
                <article class="bg-gray-800 rounded-lg overflow-hidden">
                    @if($blog->thumbnail)
                        <div class="aspect-video">
                            <img src="{{ asset('storage/' . $blog->thumbnail) }}"
                                 alt="{{ $blog->title }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div class="p-6 lg:p-8">
                        <div class="flex items-center space-x-4 text-gray-400 text-sm mb-4">
                            <time datetime="{{ $blog->published_at->format('Y-m-d') }}">
                                {{ $blog->published_at->format('Y年m月d日') }}
                            </time>
                            <span>{{ number_format($blog->view_count) }} views</span>
                        </div>

                        <h1 class="text-2xl lg:text-3xl font-bold mb-6">{{ $blog->title }}</h1>

                        <div class="prose prose-invert max-w-none">
                            {!! nl2br(e($blog->content)) !!}
                        </div>
                    </div>
                </article>

                @if($recentBlogs->count() > 0)
                    <div class="mt-8">
                        <h2 class="text-xl font-bold mb-4">{{ $cast->name }}の他のブログ</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($recentBlogs as $recentBlog)
                                <a href="{{ route('cast.blog.show', [$cast, $recentBlog]) }}"
                                   class="bg-gray-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-pink-500 transition group">
                                    <div class="aspect-video relative overflow-hidden">
                                        @if($recentBlog->thumbnail)
                                            <img src="{{ asset('storage/' . $recentBlog->thumbnail) }}"
                                                 alt="{{ $recentBlog->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <p class="text-gray-400 text-xs mb-1">
                                            {{ $recentBlog->published_at->format('Y/m/d') }}
                                        </p>
                                        <h3 class="text-sm font-medium group-hover:text-pink-400 transition line-clamp-2">
                                            {{ $recentBlog->title }}
                                        </h3>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-1">
                <div class="bg-gray-800 rounded-lg p-6 sticky top-4">
                    <div class="text-center mb-4">
                        @if($cast->main_image)
                            <img src="{{ asset('storage/' . $cast->main_image) }}"
                                 alt="{{ $cast->name }}"
                                 class="w-24 h-24 rounded-full object-cover mx-auto mb-3">
                        @else
                            <div class="w-24 h-24 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                        <h3 class="font-bold text-lg">{{ $cast->name }}</h3>
                        <a href="{{ route('shop.show', $cast->shop) }}"
                           class="text-gray-400 hover:text-pink-400 transition text-sm">
                            {{ $cast->shop->name }}
                        </a>
                    </div>

                    @if($cast->self_introduction)
                        <p class="text-gray-400 text-sm mb-4 line-clamp-4">{{ $cast->self_introduction }}</p>
                    @endif

                    <div class="space-y-2">
                        <a href="{{ route('cast.show', $cast) }}"
                           class="block w-full bg-pink-500 hover:bg-pink-600 text-white text-center font-semibold py-2 rounded-lg transition">
                            プロフィール
                        </a>
                        <a href="{{ route('cast.blogs', $cast) }}"
                           class="block w-full bg-gray-700 hover:bg-gray-600 text-white text-center font-semibold py-2 rounded-lg transition">
                            ブログ一覧
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
