@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto pt-4">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                    {{ __('memory.my_memories_title') }}
                </h1>
                <p class="text-slate-400 text-sm mt-1">
                    {{ __('memory.my_memories_subtitle') }}
                </p>
            </div>

            <a href="{{ route('memories.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm px-5 py-3 rounded-xl shadow-md shadow-indigo-100 flex items-center gap-2 transition-all self-start sm:self-center transform hover:-translate-y-0.5">
                <i class="fa-solid fa-plus text-xs"></i>
                {{ __('memory.add_new') }}
            </a>
        </div>

        {{-- أزرار الفلترة --}}
        <div class="flex flex-wrap gap-2 mb-8 border-b border-slate-100 pb-5" id="filterButtonGroup">
            <button data-filter="all" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 text-white shadow-sm transition-all">
                {{ __('memory.all_moments') }}
            </button>
            <button data-filter="image" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-500 hover:text-slate-800 border border-slate-100 shadow-sm transition-all">
                {{ __('memory.photos') }}
            </button>
            <button data-filter="video" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-500 hover:text-slate-800 border border-slate-100 shadow-sm transition-all">
                {{ __('memory.videos') }}
            </button>
            <button data-filter="audio" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-500 hover:text-slate-800 border border-slate-100 shadow-sm transition-all">
                {{ __('memory.audio_notes') }}
            </button>
            <button data-filter="text" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-500 hover:text-slate-800 border border-slate-100 shadow-sm transition-all">
                {{ __('memory.text_notes') }}
            </button>
            <button data-filter="favorite" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-500 hover:text-slate-800 border border-slate-100 shadow-sm transition-all">
                {{ __('home.favorites') }}
            </button>
        </div>

        {{-- حالة البحث الفارغ --}}
        <div id="jsEmptyState" class="hidden col-span-full bg-white/40 border-2 border-dashed border-slate-200 rounded-3xl p-12 text-center flex flex-col items-center justify-center mb-6">
            <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mb-4">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <h3 id="jsEmptyStateTitle" class="font-bold text-slate-800 text-md">
                {{ __('memory.no_items_found') }}
            </h3>
            <p class="text-slate-400 text-xs mt-1 max-w-xs leading-relaxed">
                {{ __('memory.no_items_desc') }}
            </p>
        </div>

        {{-- شبكة عرض الذكريات --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="memoriesGrid">
            @forelse($memories ?? [] as $memory)
                {{-- استدعاء المكون الخاص بالكارد وتمرير المتغير له --}}
                <x-memory.memory-card :memory="$memory" />
            @empty
                <div class="col-span-full bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-12 text-center flex flex-col items-center justify-center">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-2xl mb-4">
                        <i class="fa-regular fa-images"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-md">{{ __('memory.no_items_found') }}</h3>
                    <p class="text-slate-400 text-xs mt-1 max-w-xs leading-relaxed">{{ __('memory.no_items_desc') }}</p>
                    <a href="{{ route('memories.create') }}" class="mt-5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs px-4 py-2.5 rounded-xl shadow-md transition-all">
                        {{ __('memory.create_first') }}
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    {{-- جافاسكريبت للتحكم بالفلاتر والسلايدر الفرعي الفوري --}}
    <script>
        // دالة السلايدر المصغر في الكارد
        const activeSlides = {};
        function moveCarousel(memoryId, direction) {
            const track = document.getElementById(`track-${memoryId}`);
            if (!track) return;
            const items = track.children;
            const total = items.length;
            if (total <= 1) return;

            if (activeSlides[memoryId] === undefined) activeSlides[memoryId] = 0;
            
            // تحديث النقطة القديمة
            document.getElementById(`dot-${memoryId}-${activeSlides[memoryId]}`)?.classList.replace('bg-indigo-500', 'bg-white/50');
            document.getElementById(`dot-${memoryId}-${activeSlides[memoryId]}`)?.classList.replace('w-3', 'w-1.5');

            activeSlides[memoryId] = (activeSlides[memoryId] + direction + total) % total;

            track.style.transform = `translateX(-${activeSlides[memoryId] * 100}%)`;

            // تحديث النقطة الجديدة
            document.getElementById(`dot-${memoryId}-${activeSlides[memoryId]}`)?.classList.replace('bg-white/50', 'bg-indigo-500');
            document.getElementById(`dot-${memoryId}-${activeSlides[memoryId]}`)?.classList.replace('w-1.5', 'w-3');
        }

        // تحكم فلاتر العرض
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.filter-btn');
            const cards = document.querySelectorAll('.memory-card');
            const jsEmptyState = document.getElementById('jsEmptyState');
            const jsEmptyStateTitle = document.getElementById('jsEmptyStateTitle');

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    buttons.forEach(b => {
                        b.className = "filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-500 hover:text-slate-800 border border-slate-100 shadow-sm transition-all";
                    });
                    btn.className = "filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 text-white shadow-sm transition-all";

                    const filterValue = btn.getAttribute('data-filter');
                    const buttonText = btn.innerText.trim();
                    let visibleCardsCount = 0;

                    cards.forEach(card => {
                        const cardType = card.getAttribute('data-type');
                        const isFavorite = card.getAttribute('data-favorite');

                        if (filterValue === 'all') {
                            card.style.display = 'flex';
                            visibleCardsCount++;
                        } else if (filterValue === 'favorite') {
                            if (isFavorite === '1') {
                                card.style.display = 'flex';
                                visibleCardsCount++;
                            } else {
                                card.style.display = 'none';
                            }
                        } else if (cardType === filterValue) {
                            card.style.display = 'flex';
                            visibleCardsCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    if (visibleCardsCount === 0 && cards.length > 0) {
                        jsEmptyStateTitle.innerText = "{{ __('memory.no_found_js_prefix') }} " + buttonText + " {{ __('memory.no_found_js_suffix') }}";
                        jsEmptyState.classList.remove('hidden');
                        jsEmptyState.classList.add('flex');
                    } else {
                        jsEmptyState.classList.remove('flex');
                        jsEmptyState.classList.add('hidden');
                    }
                });
            });
        });
    </script>
@endsection