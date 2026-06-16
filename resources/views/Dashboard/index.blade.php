@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col items-center justify-center text-center pt-6">
    
    <span class="bg-white/80 border border-slate-200/50 text-[10px] font-bold tracking-wider text-indigo-600 px-3 py-1 rounded-full uppercase shadow-sm mb-4">
        {{ __('home.welcome_back') }}
    </span>

    <h1 class="text-4xl md:text-5xl font-bold text-slate-900 tracking-tight leading-none">
        {{ __('home.hello') }},
        <span class="text-slate-800">{{ auth()->user()->name }}</span>
    </h1>

    <h2 class="text-4xl md:text-5xl font-bold text-[#6366f1] tracking-tight mt-1 mb-4">
        {{ __('home.ready_message') }}
    </h2>

    <p class="text-slate-400 max-w-lg text-sm font-medium leading-relaxed mb-8">
        {{ __('home.description') }}
    </p>

    <a href="{{ route('memories.create') }}" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white font-medium text-sm px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 flex items-center gap-2 transition-all mb-12 transform hover:-translate-y-0.5">
        <i class="fa-solid fa-plus text-xs"></i>
        {{ __('home.add_memory') }}
    </a>

    <form action="{{ route('memories.search') }}" method="GET" id="homeSearchForm" class="w-full max-w-2xl bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between mb-12">
        <div class="flex items-center gap-3 flex-1 px-2">
            <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
            <input type="text"
                name="search"
                id="homeSearchInput"
                placeholder="{{ __('home.search_placeholder') }}"
                class="w-full bg-transparent text-sm font-medium text-slate-700 outline-none placeholder-slate-300">
        </div>
        
        {{-- أيقونة المايكروفون (تظهر لما يكون الحقل فارغ) --}}
        <button type="button" id="voiceSearchBtn" class="text-indigo-500 hover:text-indigo-700 p-1 px-2 transition-all duration-200">
            <i class="fa-solid fa-microphone text-md"></i>
        </button>

        {{-- زر البحث الحقيقي (يكون مخفي ويظهر أول ما يبدأ المستخدم يكتب) --}}
        <button type="submit" id="submitSearchBtn" class="hidden bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition-all duration-200 shadow-sm shadow-indigo-100 operations-btn animate-fade-in">
            {{ __('home.search') }}
        </button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-4xl text-left mb-10">

        <div class="bg-white/70 backdrop-blur-sm border border-slate-100 p-5 rounded-2xl flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-regular fa-image"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('home.photos_videos') }}</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $photosVideosCount ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white/70 backdrop-blur-sm border border-slate-100 p-5 rounded-2xl flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-purple-50 text-purple-500 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-regular fa-pen-to-square"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('home.journal_entries') }}</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $totalEntriesCount ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white/70 backdrop-blur-sm border border-slate-100 p-5 rounded-2xl flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-regular fa-star"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('home.favorites') }}</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $favoritesCount ?? 0 }}</h3>
            </div>
        </div>

    </div>

    <div class="w-full max-w-4xl text-left mb-12">

        <div class="flex justify-between items-center mb-6">
            <h4 class="font-bold text-slate-800 text-md">
                {{ __('home.recent_memories') }}
            </h4>

            <a href="{{ route('memories.index') }}"
               class="bg-[#4f46e5] hover:bg-[#4338ca] text-white font-medium text-xs px-4 py-2 rounded-xl shadow-md shadow-indigo-200 flex items-center gap-2 transition-all transform hover:-translate-y-0.5">
                {{ __('home.view_all') }}
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 w-full" id="homeMemoriesGrid">
            
            @forelse($memories->take(4) ?? [] as $memory)
                @php
                    $firstMedia = $memory->media ? $memory->media->first() : null;
                    $mediaType = $firstMedia ? $firstMedia->media_type : 'text';
                    $hasMultipleMedia = $memory->media && $memory->media->count() > 1;
                    $hasMedia = $memory->media && $memory->media->count() > 0;
                @endphp

                <div onclick="window.location='{{ route('memories.show', $memory->id) }}'" 
                    class="bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-4 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group relative overflow-hidden cursor-pointer">
                    <div>
                        @if ($hasMedia)
                            <div class="w-full h-32 rounded-2xl overflow-hidden bg-slate-900 mb-3 border border-slate-50 relative shadow-inner group/carousel group/media">

                                <div class="carousel-track flex h-full transition-transform duration-300 will-change-transform" id="track-{{ $memory->id }}">
                                    @foreach ($memory->media as $index => $item)
                                        <div class="carousel-item w-full min-w-full h-full shrink-0 relative">
                                            @if ($item->media_type == 'image')
                                                <img src="{{ asset('storage/' . $item->media_path) }}" alt="{{ $memory->title }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover/media:scale-[1.02]">
                                            @elseif($item->media_type == 'audio')
                                                <div onclick="event.stopPropagation();" class="w-full h-full flex flex-col items-center justify-center bg-slate-900 text-slate-400 p-1">
                                                    <i class="fa-solid fa-waveform text-xl mb-1 text-indigo-500/50"></i>
                                                    <audio src="{{ asset('storage/' . $item->media_path) }}" controls class="w-11/12 h-6 opacity-90"></audio>
                                                </div>
                                            @else
                                                <video src="{{ asset('storage/' . $item->media_path) }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover/media:scale-[1.02]" muted playsinline></video>
                                                <div class="absolute inset-0 flex items-center justify-center bg-black/20 z-10">
                                                    <div class="w-8 h-8 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-slate-800 shadow-sm">
                                                        <i class="fa-solid fa-play text-[9px] ml-0.5"></i>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                @if ($hasMultipleMedia)
                                    <button type="button" onclick="event.stopPropagation(); prevSlide({{ $memory->id }}, {{ $memory->media->count() }})"
                                        class="absolute left-1 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center shadow-sm opacity-0 group-hover/carousel:opacity-100 transition-opacity z-20">
                                        <i class="fa-solid fa-chevron-left text-[9px]"></i>
                                    </button>
                                    <button type="button" onclick="event.stopPropagation(); nextSlide({{ $memory->id }}, {{ $memory->media->count() }})"
                                        class="absolute right-1 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center shadow-sm opacity-0 group-hover/carousel:opacity-100 transition-opacity z-20">
                                        <i class="fa-solid fa-chevron-right text-[9px]"></i>
                                    </button>

                                    <div class="absolute bottom-1 left-1/2 -translate-x-1/2 flex gap-0.5 z-20" id="dots-{{ $memory->id }}">
                                        @foreach ($memory->media as $index => $item)
                                            <span class="w-1 h-1 rounded-full bg-white/40 transition-all {{ $index === 0 ? 'bg-white !w-2' : '' }}"></span>
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                        @else
                            <div class="w-full h-32 rounded-2xl bg-gradient-to-br from-indigo-50/40 to-slate-50 border border-slate-100 p-3 mb-3 flex flex-col justify-center items-center text-center overflow-hidden relative group-hover:scale-[1.01] transition-transform duration-300">
                                <div class="absolute top-1 left-2 text-indigo-200/30">
                                    <i class="fa-solid fa-quote-left text-xl"></i>
                                </div>
                                <p class="text-slate-600 text-[11px] font-medium leading-relaxed line-clamp-4 px-1 relative z-10">
                                    {{ $memory->description ?? __('memory.text_notes') }}
                                </p>
                            </div>
                        @endif

                        <div class="block group">
                            <h5 class="font-bold text-slate-800 text-xs md:text-sm leading-snug group-hover:text-indigo-600 transition-colors line-clamp-1">
                                {{ $memory->title }}
                            </h5>
                        </div>
                        
                        @if ($hasMedia)
                            <p class="text-[11px] text-slate-400 font-medium mt-1 mb-2 line-clamp-2">
                                {{ $memory->description }}
                            </p>
                        @else
                            <div class="mb-2"></div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between border-t border-slate-50/60 pt-3 mt-1" onclick="event.stopPropagation();">
                        <span class="text-[10px] font-bold text-slate-400 flex items-center gap-1">
                            <i class="fa-regular fa-calendar text-[9px]"></i> 
                            {{ $memory->created_at ? $memory->created_at->format('M d, Y') : 'Recent' }}
                        </span>
                        <div class="flex items-center gap-2">
                            <form action="{{ route('memories.favorite', $memory->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="p-1 rounded-md transition-all {{ $memory->is_favorite ? 'text-amber-400 hover:text-amber-500' : 'text-slate-300 hover:text-amber-400' }}" title="Favorite">
                                    <i class="{{ $memory->is_favorite ? 'fa-solid' : 'fa-regular' }} fa-star text-[10px]"></i>
                                </button>
                            </form>
                            
                            <a href="{{ route('memories.show', $memory->id) }}" class="text-[10px] font-bold text-indigo-500 hover:text-indigo-700 transition-colors">
                                Details <i class="fa-solid fa-angle-right text-[8px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                @for ($i = 0; $i < 4; $i++)
                    <div class="bg-white/40 border-2 border-dashed border-slate-200/60 h-44 rounded-3xl flex flex-col items-center justify-center text-xs text-slate-400 font-medium p-4 text-center">
                        <span>{{ __('home.empty_slot') }}</span>
                        <a href="{{ route('memories.create') }}" class="text-[10px] text-indigo-500 mt-1 hover:underline">+ Add</a>
                    </div>
                @endfor
            @endforelse
            
        </div>

    </div>

</div>

<script>
    const carouselIndices = {};

    function updateCarousel(memoryId, count) {
        const track = document.getElementById(`track-${memoryId}`);
        const dotsContainer = document.getElementById(`dots-${memoryId}`);
        const index = carouselIndices[memoryId] || 0;

        track.style.transform = `translateX(-${index * 100}%)`;

        if (dotsContainer) {
            const dots = dotsContainer.children;
            for (let i = 0; i < dots.length; i++) {
                if (i === index) {
                    dots[i].classList.add('bg-white', '!w-2');
                    dots[i].classList.remove('bg-white/40');
                } else {
                    dots[i].classList.remove('bg-white', '!w-2');
                    dots[i].classList.add('bg-white/40');
                }
            }
        }
    }

    function nextSlide(memoryId, count) {
        if (!carouselIndices[memoryId]) carouselIndices[memoryId] = 0;
        carouselIndices[memoryId] = (carouselIndices[memoryId] + 1) % count;
        updateCarousel(memoryId, count);
    }

    function prevSlide(memoryId, count) {
        if (!carouselIndices[memoryId]) carouselIndices[memoryId] = 0;
        carouselIndices[memoryId] = (carouselIndices[memoryId] - 1 + count) % count;
        updateCarousel(memoryId, count);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const isRtl = document.documentElement.dir === 'rtl' || document.body.style.direction === 'rtl';
        document.querySelectorAll('.carousel-track').forEach(track => {
            if (isRtl) {
                track.classList.remove('flex');
                track.style.display = 'flex';
                track.style.flexDirection = 'row-reverse';
            }
        });
    });
    
</script>
@endsection