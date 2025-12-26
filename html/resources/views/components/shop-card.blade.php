@props(['shop'])

<article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition group">
    <a href="{{ route('shop.show', $shop) }}" class="block">
        <div class="aspect-[4/3] relative overflow-hidden">
            @if($shop->main_image)
                <img src="{{ asset('storage/' . $shop->main_image) }}"
                     alt="{{ $shop->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
            @else
                <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            @if($shop->is_featured)
                <span class="absolute top-2 left-2 bg-pink-500 text-white text-xs px-2 py-1 rounded">
                    おすすめ
                </span>
            @endif

            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-3">
                <div class="flex flex-wrap gap-1">
                    @foreach($shop->businessTypes->take(2) as $type)
                        <span class="text-xs bg-pink-500/80 text-white px-2 py-0.5 rounded">
                            {{ $type->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="p-4">
            <h3 class="font-bold text-lg text-gray-100 group-hover:text-pink-400 transition truncate">
                {{ $shop->name }}
            </h3>

            <p class="text-gray-400 text-sm mt-1">
                {{ $shop->area->prefecture->name ?? '' }} / {{ $shop->area->name ?? '' }}
            </p>

            @if($shop->catch_copy)
                <p class="text-gray-300 text-sm mt-2 line-clamp-2">
                    {{ $shop->catch_copy }}
                </p>
            @endif

            <div class="flex items-center justify-between mt-3 text-sm text-gray-500">
                <div class="flex items-center space-x-3">
                    @if($shop->average_rating)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span>{{ $shop->average_rating }}</span>
                            @if($shop->review_count)
                                <span class="text-gray-600 ml-1">({{ $shop->review_count }})</span>
                            @endif
                        </div>
                    @endif
                </div>

                <span>{{ number_format($shop->view_count) }} views</span>
            </div>
        </div>
    </a>
</article>
