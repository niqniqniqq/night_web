@extends('layouts.app')

@section('title', $shop->name . 'の口コミを投稿')
@section('description', $shop->name . 'への口コミ・レビューを投稿できます')

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
                <li class="text-gray-200">口コミを投稿</li>
            </ol>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-gray-800 rounded-lg p-6 mb-6">
                <h1 class="text-2xl font-bold mb-2">口コミを投稿</h1>
                <p class="text-gray-400">{{ $shop->name }}への口コミ・レビューを投稿してください</p>
            </div>

            <form action="{{ route('review.store', $shop) }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-gray-800 rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">投稿者情報</h2>

                    <div class="space-y-4">
                        <div>
                            <label for="nickname" class="block text-sm font-medium text-gray-300 mb-2">
                                ニックネーム <span class="text-red-400">*</span>
                            </label>
                            <input type="text"
                                   name="nickname"
                                   id="nickname"
                                   value="{{ old('nickname') }}"
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500"
                                   placeholder="例: ゲスト"
                                   maxlength="50"
                                   required>
                            @error('nickname')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="visit_date" class="block text-sm font-medium text-gray-300 mb-2">
                                来店日
                            </label>
                            <input type="date"
                                   name="visit_date"
                                   id="visit_date"
                                   value="{{ old('visit_date') }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500">
                            @error('visit_date')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">評価</h2>

                    <div class="grid grid-cols-2 gap-4">
                        @foreach([
                            'rating_overall' => '総合評価',
                            'rating_service' => '接客',
                            'rating_atmosphere' => '雰囲気',
                            'rating_cost_performance' => 'コスパ',
                        ] as $field => $label)
                            <div x-data="{ rating: {{ old($field, 0) }}, hover: 0 }">
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    {{ $label }} <span class="text-red-400">*</span>
                                </label>
                                <input type="hidden" name="{{ $field }}" x-model="rating">
                                <div class="flex space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                                @click="rating = {{ $i }}"
                                                @mouseenter="hover = {{ $i }}"
                                                @mouseleave="hover = 0"
                                                class="text-2xl focus:outline-none transition-transform hover:scale-110"
                                                :class="(hover >= {{ $i }} || rating >= {{ $i }}) ? 'text-yellow-400' : 'text-gray-600'">
                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                @error($field)
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gray-800 rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">口コミ内容</h2>

                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                                タイトル <span class="text-red-400">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   value="{{ old('title') }}"
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500"
                                   placeholder="例: とても楽しいお店でした！"
                                   maxlength="255"
                                   required>
                            @error('title')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-300 mb-2">
                                本文 <span class="text-red-400">*</span>
                            </label>
                            <textarea name="content"
                                      id="content"
                                      rows="6"
                                      class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 resize-none"
                                      placeholder="お店の感想を書いてください（接客、雰囲気、料金など）"
                                      maxlength="2000"
                                      required>{{ old('content') }}</textarea>
                            <p class="text-gray-500 text-sm mt-1">2000文字まで</p>
                            @error('content')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800/50 rounded-lg p-4 text-sm text-gray-400">
                    <p>投稿された口コミは管理者による確認後に公開されます。</p>
                    <p>誹謗中傷や虚偽の内容は公開されません。</p>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('shop.show', $shop) }}"
                       class="text-gray-400 hover:text-white transition">
                        キャンセル
                    </a>
                    <button type="submit"
                            class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-8 py-3 rounded-lg transition">
                        口コミを投稿する
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
