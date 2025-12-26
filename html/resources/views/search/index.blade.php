@extends('layouts.app')

@section('title', '店舗検索 - ナイトナビ')

@section('content')
    <div class="bg-gray-800 py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold mb-4">店舗検索</h1>

            <form action="{{ route('search') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">都道府県</label>
                        <select name="prefecture"
                                class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-pink-500"
                                onchange="this.form.submit()">
                            <option value="">すべて</option>
                            @foreach($prefectures as $prefecture)
                                <option value="{{ $prefecture->id }}" {{ request('prefecture') == $prefecture->id ? 'selected' : '' }}>
                                    {{ $prefecture->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($areas->count() > 0)
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">エリア</label>
                            <select name="area"
                                    class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-pink-500">
                                <option value="">すべて</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">業種</label>
                        <select name="type"
                                class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-pink-500">
                            <option value="">すべて</option>
                            @foreach($businessTypes as $type)
                                <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">キーワード</label>
                        <input type="text" name="q" value="{{ request('q') }}"
                               placeholder="店舗名・キーワード"
                               class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-pink-500">
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="featured" value="1"
                                   {{ request()->boolean('featured') ? 'checked' : '' }}
                                   class="w-4 h-4 bg-gray-700 border-gray-600 rounded text-pink-500 focus:ring-pink-500">
                            <span class="text-sm text-gray-300">おすすめのみ</span>
                        </label>

                        <div class="flex items-center space-x-2">
                            <label class="text-sm text-gray-400">並び替え:</label>
                            <select name="sort"
                                    class="px-3 py-1 bg-gray-700 border border-gray-600 rounded text-sm text-gray-100 focus:ring-2 focus:ring-pink-500"
                                    onchange="this.form.submit()">
                                <option value="new" {{ request('sort', 'new') == 'new' ? 'selected' : '' }}>新着順</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>人気順</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>評価順</option>
                                <option value="review_count" {{ request('sort') == 'review_count' ? 'selected' : '' }}>口コミ数順</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit"
                            class="px-6 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-lg transition">
                        検索
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
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
                <p class="text-gray-400 text-lg mb-2">店舗が見つかりませんでした</p>
                <p class="text-gray-500">条件を変更して再度検索してください</p>
            </div>
        @endif
    </div>
@endsection
