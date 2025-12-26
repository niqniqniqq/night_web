<footer class="bg-gray-800 border-t border-gray-700 mt-auto">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-lg font-bold text-pink-500 mb-4">NightNavi</h3>
                <p class="text-gray-400 text-sm">
                    関東エリアのキャバクラ・ガールズバー・スナック情報を掲載するポータルサイトです。
                </p>
            </div>

            <div>
                <h4 class="font-semibold text-gray-200 mb-4">エリアから探す</h4>
                <ul class="space-y-2 text-sm">
                    @php
                        $footerPrefectures = \App\Models\Prefecture::active()->ordered()->get();
                    @endphp
                    @foreach($footerPrefectures as $pref)
                        <li>
                            <a href="{{ route('area.prefecture', $pref) }}"
                               class="text-gray-400 hover:text-pink-400 transition">
                                {{ $pref->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-gray-200 mb-4">業種から探す</h4>
                <ul class="space-y-2 text-sm">
                    @php
                        $footerTypes = \App\Models\BusinessType::active()->ordered()->get();
                    @endphp
                    @foreach($footerTypes as $type)
                        <li>
                            <a href="{{ route('genre.index', $type) }}"
                               class="text-gray-400 hover:text-pink-400 transition">
                                {{ $type->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-gray-200 mb-4">サイトについて</h4>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="#" class="text-gray-400 hover:text-pink-400 transition">
                            利用規約
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-pink-400 transition">
                            プライバシーポリシー
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-pink-400 transition">
                            お問い合わせ
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} NightNavi. All rights reserved.</p>
        </div>
    </div>
</footer>
