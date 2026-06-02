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

    <div class="flex flex-wrap gap-2 mb-8 border-b border-slate-100 pb-5" id="filterButtonGroup">

        <button data-filter="all"
            class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 text-white shadow-sm transition-all">
            {{ __('memory.all_moments') }}
        </button>

        <button data-filter="image"
            class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-500 hover:text-slate-800 border border-slate-100 shadow-sm transition-all">
            {{ __('memory.photos') }}
        </button>

        <button data-filter="video"
            class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-500 hover:text-slate-800 border border-slate-100 shadow-sm transition-all">
            {{ __('memory.videos') }}
        </button>

        <button data-filter="voice"
            class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-500 hover:text-slate-800 border border-slate-100 shadow-sm transition-all">
            {{ __('memory.voice_notes') }}
        </button>

    </div>

    <div id="jsEmptyState"
        class="hidden col-span-full bg-white/40 border-2 border-dashed border-slate-200 rounded-3xl p-12 text-center flex flex-col items-center justify-center mb-6">

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

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="memoriesGrid">

        @forelse($memories ?? [] as $memory)

            <div data-type="{{ $memory->media_type }}"
                class="memory-card bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group relative overflow-hidden">

                <div>

                    <div class="flex items-center justify-between mb-4">

                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">
                            {{ $memory->media_type == 'image'
                                ? __('memory.photo')
                                : ($memory->media_type == 'video'
                                    ? __('memory.video')
                                    : __('memory.voice')) }}
                        </span>

                        <div class="text-slate-400 text-md">
                            <i class="{{ $memory->media_type == 'image' ? 'fa-regular fa-image' : 'fa-regular fa-file-video' }}"></i>
                        </div>

                    </div>

                    @if($memory->media_path)

                        <div class="w-full h-44 rounded-2xl overflow-hidden bg-slate-900 mb-4 border border-slate-50 relative group-hover:scale-[1.01] transition-transform duration-300 shadow-inner">

                            @if($memory->media_type == 'image')
                                <img src="{{ asset('storage/' . $memory->media_path) }}"
                                     alt="{{ $memory->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <video src="{{ asset('storage/' . $memory->media_path) }}"
                                       class="w-full h-full object-cover"
                                       muted playsinline></video>

                                <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                                    <div class="w-10 h-10 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-slate-800 shadow-sm">
                                        <i class="fa-solid fa-play text-xs ml-0.5"></i>
                                    </div>
                                </div>
                            @endif

                        </div>

                    @endif

                    <a href="{{ route('memories.show', $memory->id) }}" class="block group">

                        <h3 class="font-bold text-slate-800 text-md leading-snug group-hover:text-indigo-600 transition-colors">
                            {{ $memory->title }}
                        </h3>

                    </a>

                    <p class="text-xs text-slate-400 font-medium mt-1.5 mb-4 line-clamp-2">
                        {{ $memory->description }}
                    </p>

                </div>

                <div class="flex items-center justify-between border-t border-slate-50 pt-4 mt-2">

                    <span class="text-xs font-semibold text-slate-400">
                        <i class="fa-regular fa-calendar text-[11px] mr-1"></i>

                        {{ $memory->created_at
                            ? $memory->created_at->format('M d, Y')
                            : __('memory.default_date') }}
                    </span>

                    <div class="flex items-center gap-1">

                        <a href="{{ route('memories.edit', $memory->id) }}"
                           class="text-slate-300 hover:text-indigo-600 p-1.5 rounded-lg hover:bg-indigo-50 transition-all"
                           title="{{ __('memory.edit') }}">
                            <i class="fa-regular fa-pen-to-square text-sm"></i>
                        </a>

                        <form action="{{ route('memories.destroy', $memory->id) }}"
                              method="POST"
                              onsubmit="return confirm('{{ __('memory.delete_confirm') }}')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="text-slate-300 hover:text-red-500 p-1.5 rounded-lg hover:bg-red-50 transition-all">
                                <i class="fa-regular fa-trash-can text-sm"></i>
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-span-full bg-white/40 border-2 border-dashed border-slate-200 rounded-3xl p-12 text-center flex flex-col items-center justify-center">

                <div class="w-16 h-16 rounded-2xl bg-indigo-50/50 text-indigo-400 flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid fa-box-open"></i>
                </div>

                <h3 class="font-bold text-slate-800 text-md">
                    {{ __('memory.empty_title') }}
                </h3>

                <p class="text-slate-400 text-xs mt-1 max-w-xs leading-relaxed">
                    {{ __('memory.empty_desc') }}
                </p>

                <a href="{{ route('memories.create') }}"
                   class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md shadow-indigo-50 transition-all">

                    {{ __('memory.create_first') }}

                </a>

            </div>

        @endforelse

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const buttons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.memory-card');
    const jsEmptyState = document.getElementById('jsEmptyState');
    const jsEmptyStateTitle = document.getElementById('jsEmptyStateTitle');

    buttons.forEach(button => {
        button.addEventListener('click', function () {

            const filterValue = this.getAttribute('data-filter');
            const buttonText = this.innerText;
            let visibleCardsCount = 0;

            buttons.forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white');
                btn.classList.add('bg-white', 'text-slate-500', 'hover:text-slate-800', 'border', 'border-slate-100');
            });

            this.classList.remove('bg-white', 'text-slate-500', 'hover:text-slate-800', 'border', 'border-slate-100');
            this.classList.add('bg-indigo-600', 'text-white');

            cards.forEach(card => {
                const cardType = card.getAttribute('data-type');

                if (filterValue === 'all' || cardType === filterValue) {
                    card.style.display = 'flex';
                    visibleCardsCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (visibleCardsCount === 0 && cards.length > 0) {
                jsEmptyStateTitle.innerText = "{{ __('memory.no_found_js_prefix') }}" + buttonText + "{{ __('memory.no_found_js_suffix') }}";
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