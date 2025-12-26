@extends('layouts.app')

@section('title', $prefecture->name . 'の' . $businessType->name)

@section('content')
    <nav class="bg-gray-800 py-3">
        <div class="container mx-auto px-4">
            <ol class="flex items-center text-sm text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-pink-400">TOP</a></li>
                <li class="mx-2">/</li>
                <li><a href="{{ route('genre.index', $businessType) }}" class="hover:text-pink-400">{{ $businessType->name }}</a></li>
                <li class="mx-2">/</li>
                <li class="text-gray-200">{{ $prefecture->name }}</li>
            </ol>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">{{ $prefecture->name }}の{{ $businessType->name }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <aside class="lg:col-span-1">
                <div class="bg-gray-800 rounded-lg p-4">
                    <h2 class="font-bold mb-4">エリアで絞り込む</h2>
                    <ul class="space-y-2">
                        @foreach($areas as $area)
                            <li>
                                <a href="{{ route('area.show', [$prefecture, $area, 'type' => $businessType->id]) }}"
                                   class="text-gray-300 hover:text-pink-400 transition block py-1">
                                    {{ $area->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <main class="lg:col-span-3">
                @if($shops->count() > 0)
                    <p class="text-gray-400 mb-4">{{ $shops->total() }}件の店舗が見つかりました</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
            </main>
        </div>
    </div>
@endsection
