@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto pt-4 space-y-6">
    
    <div class="flex items-center justify-between border-b border-slate-100 pb-4">

        <a href="{{ route('memories.index') }}"
           class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">

            <i class="fa-solid fa-arrow-left"></i>
            {{ __('memory.back_to_memories') }}

        </a>

        <div class="flex items-center gap-2">
            <form action="{{ route('memories.favorite', $memory->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="bg-white border border-slate-200 {{ $memory->is_favorite ? 'text-amber-500 hover:bg-amber-50' : 'text-slate-400 hover:text-amber-500 hover:bg-slate-50' }} text-xs font-bold px-4 py-2 rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <i class="{{ $memory->is_favorite ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                    {{ __('home.favorites') }}
                </button>
            </form>

            <a href="{{ route('memories.edit', $memory->id) }}"
               class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold px-4 py-2 rounded-xl shadow-sm transition-all flex items-center gap-2">

                <i class="fa-regular fa-pen-to-square"></i>
                {{ __('memory.edit') }}

            </a>

            <form action="{{ route('memories.destroy', $memory->id) }}"
                  method="POST"
                  onsubmit="return confirm('{{ __('memory.delete_confirm') }}')">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold px-4 py-2 rounded-xl transition-all flex items-center gap-2">

                    <i class="fa-regular fa-trash-can"></i>
                    {{ __('memory.delete') }}

                </button>

            </form>

        </div>
    </div>

    <div class="bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
        
        <div class="space-y-2">

            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">

                <span class="bg-indigo-50 text-indigo-600 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                    {{ $memory->media_type == 'image'
                        ? __('memory.photo')
                        : ($memory->media_type == 'video'
                            ? __('memory.video')
                            : ($memory->media_type == 'audio' ? __('memory.voice') : __('memory.text'))) }}
                </span>

                <span>•</span>

                <span>
                    <i class="fa-regular fa-calendar-days mr-1"></i>
                    {{ $memory->created_at->format('M d, Y') }}
                </span>

            </div>

            <h1 class="text-3xl font-bold text-slate-900 tracking-tight leading-tight">
                {{ $memory->title }}
            </h1>

        </div>

        @if($memory->media_path)

            <div class="rounded-2xl overflow-hidden bg-slate-900 shadow-sm border border-slate-100 flex items-center justify-center max-h-[450px]">

                @if($memory->media_type == 'image')
                    <img src="{{ asset('storage/' . $memory->media_path) }}"
                         alt="{{ $memory->title }}"
                         class="object-contain w-full max-h-[450px]">
                @elseif($memory->media_type == 'audio')
                    <div class="w-full flex flex-col items-center justify-center p-12 bg-slate-900">
                        <i class="fa-solid fa-waveform fa-4x mb-6 text-indigo-500/50"></i>
                        <audio src="{{ asset('storage/' . $memory->media_path) }}" controls class="w-3/4 max-w-md h-12 opacity-90"></audio>
                    </div>
                @else
                    <video src="{{ asset('storage/' . $memory->media_path) }}"
                           controls
                           class="w-full max-h-[450px]"></video>
                @endif

            </div>

        @endif

        <div class="pt-4 border-t border-slate-50">

            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">
                {{ __('memory.story') }}
            </h3>

            <p class="text-slate-700 text-base leading-relaxed whitespace-pre-line bg-slate-50/50 p-5 rounded-2xl border border-slate-200/40 shadow-inner">
                {{ $memory->description ?? __('memory.no_description') }}
            </p>

        </div>

    </div>
</div>
@endsection