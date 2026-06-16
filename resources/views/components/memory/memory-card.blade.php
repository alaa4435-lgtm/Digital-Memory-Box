@props(['memory'])

@php
    $firstMedia = $memory->media ? $memory->media->first() : null;
    $mediaType = $firstMedia ? $firstMedia->media_type : 'text';
    $hasMultipleMedia = $memory->media && $memory->media->count() > 1;
    $hasMedia = $memory->media && $memory->media->count() > 0;
@endphp

<div data-type="{{ $mediaType }}" data-favorite="{{ $memory->is_favorite ? '1' : '0' }}"
    onclick="window.location='{{ route('memories.show', $memory->id) }}'"
    class="memory-card bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group relative overflow-hidden cursor-pointer">

    <div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">
                {{ $mediaType == 'image'
                    ? __('memory.photo')
                    : ($mediaType == 'video'
                        ? __('memory.video')
                        : ($mediaType == 'audio' ? __('memory.voice') : __('memory.text'))) }}
                
                @if ($hasMultipleMedia)
                    (+{{ $memory->media->count() - 1 }})
                @endif
            </span>

            <div class="text-slate-400 text-md">
                <i class="{{ $mediaType == 'image' ? 'fa-regular fa-image' : ($mediaType == 'video' ? 'fa-solid fa-video' : ($mediaType == 'audio' ? 'fa-solid fa-microphone-lines' : 'fa-solid fa-align-left')) }}"></i>
            </div>
        </div>

        {{-- منطقة عرض الميديا أو السلايدر للميديا المتعددة --}}
        @if($hasMedia)
            <div class="w-full h-44 rounded-2xl overflow-hidden bg-slate-900 mb-4 border border-slate-50 relative shadow-inner group/carousel group/media">
                <div class="carousel-track flex h-full transition-transform duration-300 will-change-transform" id="track-{{ $memory->id }}">
                    @foreach ($memory->media as $index => $item)
                        <div class="carousel-item w-full min-w-full h-full shrink-0 relative">
                            @if ($item->media_type == 'image')
                                <img src="{{ asset('storage/' . $item->media_path) }}" alt="{{ $memory->title }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover/media:scale-[1.02]">
                            @elseif($item->media_type == 'audio')
                                <div onclick="event.stopPropagation();" class="w-full h-full flex flex-col items-center justify-center bg-slate-900 text-slate-400">
                                    <i class="fa-solid fa-waveform fa-2x mb-2 text-indigo-500/50"></i>
                                    <audio src="{{ asset('storage/' . $item->media_path) }}" controls class="w-11/12 h-9 opacity-90"></audio>
                                </div>
                            @else
                                <video src="{{ asset('storage/' . $item->media_path) }}" class="w-full h-full object-cover" preload="metadata"></video>
                                <div class="absolute inset-0 flex items-center justify-center bg-black/10 text-white text-xl">
                                    <i class="fa-solid fa-play p-3 bg-white/20 backdrop-blur-md rounded-full shadow-sm"></i>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- أزرار التنقل للسلايدر المتعدد --}}
                @if ($hasMultipleMedia)
                    <button onclick="event.stopPropagation(); moveCarousel('{{ $memory->id }}', -1)" class="absolute left-2 top-1/2 -translate-y-1/2 w-7 h-7 bg-white/80 backdrop-blur-md text-slate-700 rounded-full flex items-center justify-center text-xs shadow-sm opacity-0 group-hover/carousel:opacity-100 transition-all hover:bg-white">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button onclick="event.stopPropagation(); moveCarousel('{{ $memory->id }}', 1)" class="absolute right-2 top-1/2 -translate-y-1/2 w-7 h-7 bg-white/80 backdrop-blur-md text-slate-700 rounded-full flex items-center justify-center text-xs shadow-sm opacity-0 group-hover/carousel:opacity-100 transition-all hover:bg-white">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                    
                    {{-- النقاط السفلية للسلايدر --}}
                    <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1 z-10">
                        @foreach ($memory->media as $index => $item)
                            <div id="dot-{{ $memory->id }}-{{ $index }}" class="carousel-dot h-1.5 rounded-full transition-all {{ $index === 0 ? 'bg-indigo-500 w-3' : 'bg-white/50 w-1.5' }}"></div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <h2 class="font-bold text-slate-800 text-sm tracking-tight mb-1.5 line-clamp-1 group-hover:text-indigo-600 transition-colors">
            {{ $memory->title }}
        </h2>

        <p class="text-slate-400 text-xs leading-relaxed line-clamp-2 mb-4">
            {{ $memory->description }}
        </p>
    </div>

    <div class="flex items-center justify-between border-t border-slate-50 pt-3 mt-auto">
        <span class="text-[10px] font-medium text-slate-400 flex items-center gap-1">
            <i class="fa-regular fa-calendar text-[9px]"></i>
            {{ $memory->created_at ? $memory->created_at->format('M d, Y') : __('memory.default_date') }}
        </span>

        <div class="flex items-center gap-1" onclick="event.stopPropagation();">
            <form action="{{ route('memories.favorite', $memory->id) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="p-1.5 rounded-lg transition-all {{ $memory->is_favorite ? 'text-amber-400 hover:text-amber-500 hover:bg-amber-50' : 'text-slate-300 hover:text-amber-400 hover:bg-amber-50' }}" title="Favorite">
                    <i class="{{ $memory->is_favorite ? 'fa-solid' : 'fa-regular' }} fa-star text-sm"></i>
                </button>
            </form>

            <a href="{{ route('memories.edit', $memory->id) }}" class="text-slate-300 hover:text-indigo-600 p-1.5 rounded-lg hover:bg-indigo-50 transition-all" title="{{ __('memory.edit') }}">
                <i class="fa-regular fa-pen-to-square text-sm"></i>
            </a>

            <form action="{{ route('memories.destroy', $memory->id) }}" method="POST" onsubmit="return confirm('{{ __('memory.delete_confirm') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-slate-300 hover:text-red-600 p-1.5 rounded-lg hover:bg-red-50 transition-all" title="Delete">
                    <i class="fa-regular fa-trash-can text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</div>