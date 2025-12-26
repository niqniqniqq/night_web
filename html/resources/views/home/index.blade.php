@extends('layouts.app')

@section('title', 'NightNavi - 関東のキャバクラ・ガールズバー情報')

@section('content')
    <section class="bg-gradient-to-r from-pink-900/50 to-purple-900/50 py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                関東の<span class="text-pink-400">ナイトスポット</span>を探す
            </h1>
            <p class="text-gray-300 text-lg mb-8">
                キャバクラ・ガールズバー・スナック情報が満載
            </p>

            <form action="{{ route('search') }}" method="GET"
                  class="max-w-2xl mx-auto flex flex-col md:flex-row gap-3">
                <input type="text" name="q" placeholder="店舗名・キーワードで検索"
                       class="flex-1 px-4 py-3 rounded-lg bg-gray-800 border border-gray-600 text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                <button type="submit"
                        class="px-8 py-3 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-lg transition">
                    検索
                </button>
            </form>
        </div>
    </section>

    <section class="py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <span class="bg-pink-500 w-1 h-6 mr-3"></span>
                エリアから探す
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                @foreach($prefectures as $prefecture)
                    <a href="{{ route('area.prefecture', $prefecture) }}"
                       class="bg-gray-800 rounded-lg p-4 text-center hover:bg-gray-700 transition group">
                        <span class="text-lg font-semibold group-hover:text-pink-400 transition">
                            {{ $prefecture->name }}
                        </span>
                        <span class="block text-sm text-gray-500 mt-1">
                            {{ $prefecture->activeAreas->count() }}エリア
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-12 bg-gray-800/50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <span class="bg-pink-500 w-1 h-6 mr-3"></span>
                業種から探す
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                @foreach($businessTypes as $type)
                    <a href="{{ route('genre.index', $type) }}"
                       class="bg-gray-800 rounded-lg p-4 text-center hover:bg-gray-700 transition group border border-gray-700">
                        <span class="text-lg font-semibold group-hover:text-pink-400 transition">
                            {{ $type->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    @if($featuredShops->count() > 0)
        <section class="py-12">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold flex items-center">
                        <span class="bg-pink-500 w-1 h-6 mr-3"></span>
                        おすすめ店舗
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredShops as $shop)
                        <x-shop-card :shop="$shop" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($newShops->count() > 0)
        <section class="py-12 bg-gray-800/50">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold flex items-center">
                        <span class="bg-pink-500 w-1 h-6 mr-3"></span>
                        新着店舗
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($newShops as $shop)
                        <x-shop-card :shop="$shop" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
