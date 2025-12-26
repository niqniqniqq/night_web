@extends('layouts.app')

@section('title', $businessType->name . ' - ナイトナビ')

@section('content')
    <nav class="bg-gray-800 py-3">
        <div class="container mx-auto px-4">
            <ol class="flex items-center text-sm text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-pink-400">TOP</a></li>
                <li class="mx-2">/</li>
                <li class="text-gray-200">{{ $businessType->name }}</li>
            </ol>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-2">{{ $businessType->name }}</h1>
        @if($businessType->description)
            <p class="text-gray-400 mb-6">{{ $businessType->description }}</p>
        @endif

        <div class="bg-gray-800 rounded-lg p-4 mb-8">
            <h2 class="font-bold mb-4">エリアから探す</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                @foreach($prefectures as $prefecture)
                    <a href="{{ route('genre.prefecture', [$businessType, $prefecture]) }}"
                       class="text-center py-2 px-3 bg-gray-700 rounded hover:bg-gray-600 transition">
                        {{ $prefecture->name }}
                    </a>
                @endforeach
            </div>
        </div>

        @if($shops->count() > 0)
            <p class="text-gray-400 mb-4">{{ $shops->total() }}件の店舗が見つかりました</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($shops as $shop)
                    <x-shop-card :shop="$shop" />
                @endforeach
            </div>

            <div class="mt-8">
                {{ $shops->links() }}
            </div>
        @else
            <div class="bg-gray-800 rounded-lg p-8 text-center">
                <p class="text-gray-400">店舗が見つかりませんでした</p>
            </div>
        @endif
    </div>
@endsection
