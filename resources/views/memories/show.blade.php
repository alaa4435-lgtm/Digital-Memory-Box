@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto pt-4 pb-12 space-y-4">

        {{-- زر الرجوع للذكريات في الأعلى تماماً - ستايل متناسق ومميز --}}
        <div class="flex items-center justify-start">
            <a href="{{ route('memories.index') }}"
                class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-xs font-medium px-4 py-2.5 rounded-xl shadow-md shadow-indigo-200 flex items-center gap-2 transition-all transform hover:-translate-y-0.5">
                {{ __('memory.back_to_memories') }}
            </a>
        </div>

        {{-- رأس المنشور: ستايل إنستغرام --}}
        <div class="bg-white border border-slate-100 rounded-t-3xl p-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 p-[2px]">
                    <div class="w-full h-full bg-white rounded-full p-[2px] overflow-hidden flex items-center justify-center">
                        @if($memory->user->avatar)
                            <img src="{{ asset('storage/' . $memory->user->avatar) }}" class="w-full h-full object-cover"
                                alt="{{ $memory->user->name }}">
                        @else
                            <span class="text-xs font-bold text-slate-600">
                                {{ strtoupper(substr($memory->user->name ?? 'U', 0, 1)) }}
                            </span>
                        @endif

                    </div>
                </div>
                <div class="flex flex-col">
                    {{-- هنا يعرض اسم اليوزر صاحب المنشور مباشرة --}}
                    <span class="text-sm font-bold text-slate-900 tracking-tight">
                        {{ $memory->user->name ?? 'User' }}
                    </span>
                    <span class="text-[11px] text-slate-400 font-medium flex items-center gap-1">
                        <i class="fa-regular fa-calendar-days text-[10px]"></i>
                        {{ $memory->created_at->format('M d, Y') }}
                    </span>
                </div>
            </div>

            {{-- أزرار التحكم السريعة في رأس المنشور --}}
            <div class="flex items-center gap-1">
                <a href="{{ route('memories.edit', $memory->id) }}"
                    class="w-8 h-8 rounded-full hover:bg-slate-50 text-slate-500 hover:text-indigo-600 flex items-center justify-center transition-colors">
                    <i class="fa-regular fa-pen-to-square text-sm"></i>
                </a>
                <form action="{{ route('memories.destroy', $memory->id) }}" method="POST"
                    onsubmit="return confirm('{{ __('memory.delete_confirm') }}');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-8 h-8 rounded-full hover:bg-red-50 text-slate-500 hover:text-red-600 flex items-center justify-center transition-colors">
                        <i class="fa-regular fa-trash-can text-sm"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- جسم المنشور: الكاروسيل العرضي المطور --}}
        <div class="bg-white border-x border-b border-slate-100 rounded-b-3xl shadow-sm overflow-hidden group">

            @if ($memory->media && $memory->media->count() > 0)
                <div class="relative w-full aspect-square bg-slate-950 overflow-hidden">

                    {{-- شريط السلايدر الأفقي الفعلي --}}
                    <div id="slidesContainer" class="flex w-full h-full transition-transform duration-500 ease-out">
                        @foreach ($memory->media as $index => $item)
                            <x-memory.memory-media-preview :item="$item" :title="$memory->title" />
                        @endforeach
                    </div>

                    {{-- أسهم التنقل العائمة الناعمة --}}
                    @if ($memory->media->count() > 1)
                        <button onclick="changeSlide(-1)"
                            class="absolute left-3 top-1/2 -translate-y-1/2 z-20 bg-white/80 hover:bg-white border border-slate-200/50 text-slate-800 w-9 h-9 rounded-full flex items-center justify-center shadow-md transition-all opacity-0 -translate-x-2 group-hover:translate-x-0 group-hover:opacity-100">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </button>
                        <button onclick="changeSlide(1)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 z-20 bg-white/80 hover:bg-white border border-slate-200/50 text-slate-800 w-9 h-9 rounded-full flex items-center justify-center shadow-md transition-all opacity-0 translate-x-2 group-hover:translate-x-0 group-hover:opacity-100">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>

                        {{-- النقاط التفاعلية السفلية --}}
                        <div
                            class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex gap-1.5 bg-black/20 backdrop-blur-md px-2.5 py-1.5 rounded-full">
                            @foreach ($memory->media as $index => $item)
                                <span onclick="goToSlide({{ $index }})"
                                    class="slide-dot h-1.5 rounded-full cursor-pointer transition-all duration-300 {{ $index === 0 ? 'bg-white w-4' : 'bg-white/40 w-1.5 hover:bg-white/70' }}"></span>
                            @endforeach
                        </div>
                    @endif

                </div>
            @endif

            {{-- تفاصيل الذكرى بدون صناديق (ستايل إنستغرام نقي) --}}
            <div class="p-5 space-y-3">

                {{-- منطقة زر المفضلة (النجمة المضيئة) فقط --}}
                <div class="flex items-center justify-between pb-1">
                    <button onclick="toggleFavorite(this, '{{ route('memories.favorite', $memory->id) }}')"
                        data-status="{{ $memory->is_favorite ? '1' : '0' }}"
                        class="focus:outline-none transition-transform active:scale-125 duration-200">
                        @if($memory->is_favorite)
                            <i
                                class="fa-solid fa-star text-2xl text-amber-400 drop-shadow-[0_0_6px_rgba(251,191,36,0.6)] animate-[pulse_2s_infinite]"></i>
                        @else
                            <i
                                class="fa-regular fa-star text-2xl text-slate-700 hover:text-amber-400 hover:fa-solid transition-colors"></i>
                        @endif
                    </button>

                    <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">
                        {{ $memory->created_at->format('h:i A') }}
                    </span>
                </div>

                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight leading-snug">
                    {{ $memory->title }}
                </h1>

                <p class="text-slate-600 text-[15px] leading-relaxed whitespace-pre-line font-normal">
                    {{ $memory->description }}
                </p>

            </div>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const container = document.getElementById('slidesContainer');
        const slides = document.querySelectorAll('.memory-slide');
        const dots = document.querySelectorAll('.slide-dot');
        const totalSlides = {{ $memory->media ? $memory->media->count() : 0 }};

        function showSlide(index) {
            if (!container || totalSlides === 0) return;

            if (index >= totalSlides) currentSlide = 0;
            else if (index < 0) currentSlide = totalSlides - 1;
            else currentSlide = index;

            const isRTL = document.documentElement.dir === 'rtl' || document.body.style.direction === 'rtl';
            const percentage = currentSlide * 100;

            container.style.transform = `translateX(${isRTL ? percentage : -percentage}%)`;

            const allSlides = container.children;
            for (let i = 0; i < allSlides.length; i++) {
                if (i !== currentSlide) {
                    const media = allSlides[i].querySelector('video, audio');
                    if (media) media.pause();
                }
            }

            dots.forEach((dot, idx) => {
                if (idx === currentSlide) {
                    dot.classList.remove('bg-white/40', 'w-1.5');
                    dot.classList.add('bg-white', 'w-4');
                } else {
                    dot.classList.remove('bg-white', 'w-4');
                    dot.classList.add('bg-white/40', 'w-1.5');
                }
            });
        }

        function changeSlide(direction) {
            showSlide(currentSlide + direction)
        }

        function goToSlide(index) {
            showSlide(index);
        }

        function toggleFavorite(button, url) {
            const icon = button.querySelector('i');
            const isFav = button.getAttribute('data-status') === '1';

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (isFav) {
                        button.setAttribute('data-status', '0');
                        icon.className = 'fa-regular fa-star text-2xl text-slate-700 hover:text-amber-400 hover:fa-solid transition-colors';
                    } else {
                        button.setAttribute('data-status', '1');
                        icon.className = 'fa-solid fa-star text-2xl text-amber-400 drop-shadow-[0_0_6px_rgba(251,191,36,0.6)] animate-[pulse_2s_infinite]';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        document.addEventListener('DOMContentLoaded', () => {
            showSlide(currentSlide);
        });
    </script>
@endsection