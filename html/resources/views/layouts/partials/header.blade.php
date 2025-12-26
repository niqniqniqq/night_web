<header class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-pink-500 hover:text-pink-400 transition">
                NightNavi
            </a>

            <nav class="hidden md:flex items-center space-x-6">
                @php
                    $businessTypes = \App\Models\BusinessType::active()->ordered()->take(5)->get();
                @endphp
                @foreach($businessTypes as $type)
                    <a href="{{ route('genre.index', $type) }}"
                       class="text-gray-300 hover:text-pink-400 transition text-sm">
                        {{ $type->name }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center space-x-4">
                <a href="{{ route('ranking') }}"
                   class="hidden md:block text-gray-300 hover:text-pink-400 transition text-sm font-medium">
                    ランキング
                </a>

                <a href="{{ route('search') }}"
                   class="text-gray-300 hover:text-pink-400 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </a>

                <button class="md:hidden text-gray-300" id="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <nav class="hidden md:flex items-center space-x-4 py-2 border-t border-gray-700 text-sm">
            @php
                $prefectures = \App\Models\Prefecture::active()->ordered()->get();
            @endphp
            @foreach($prefectures as $pref)
                <a href="{{ route('area.prefecture', $pref) }}"
                   class="text-gray-400 hover:text-pink-400 transition">
                    {{ $pref->name }}
                </a>
            @endforeach
        </nav>
    </div>

    <div class="hidden md:hidden" id="mobile-menu">
        <div class="px-4 py-3 space-y-2 bg-gray-800 border-t border-gray-700">
            <a href="{{ route('ranking') }}"
               class="block text-pink-400 hover:text-pink-300 py-2 font-medium">
                ランキング
            </a>
            <div class="border-b border-gray-700 my-2"></div>
            @foreach($prefectures ?? [] as $pref)
                <a href="{{ route('area.prefecture', $pref) }}"
                   class="block text-gray-300 hover:text-pink-400 py-2">
                    {{ $pref->name }}
                </a>
            @endforeach
        </div>
    </div>
</header>

<script>
    document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
