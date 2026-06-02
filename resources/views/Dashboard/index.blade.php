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

    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between mb-12">
        <div class="flex items-center gap-3 flex-1 px-2">
            <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
            <input type="text"
                placeholder="{{ __('home.search_placeholder') }}"
                class="w-full bg-transparent text-sm font-medium text-slate-700 outline-none placeholder-slate-300">
        </div>
        <button class="text-indigo-500 hover:text-indigo-700 p-1 px-2">
            <i class="fa-solid fa-microphone text-md"></i>
        </button>
    </div>

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
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">0</h3>
            </div>
        </div>

    </div>

    <div class="w-full max-w-4xl text-left mb-12">

        <div class="flex justify-between items-center mb-6">
            <h4 class="font-bold text-slate-800 text-md">
                {{ __('home.recent_memories') }}
            </h4>

            <a href="{{ route('memories.index') }}"
               class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-all">
                {{ __('home.view_all') }}
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 w-full">
            
            @forelse($memories->take(4) ?? [] as $memory)
                <div class="bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-4 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group relative overflow-hidden">
                    <div>
                        @if($memory->media_path)
                            <div class="w-full h-32 rounded-2xl overflow-hidden bg-slate-900 mb-3 border border-slate-50 relative shadow-inner">
                                @if($memory->media_type == 'image')
                                    <img src="{{ asset('storage/' . $memory->media_path) }}" alt="{{ $memory->title }}" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-300">
                                @else
                                    <video src="{{ asset('storage/' . $memory->media_path) }}" class="w-full h-full object-cover" muted playsinline></video>
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/10">
                                        <div class="w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-slate-800 shadow-sm">
                                            <i class="fa-solid fa-play text-[9px] ml-0.5"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="w-full h-32 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 text-lg mb-3 border border-dashed border-slate-200">
                                <i class="fa-regular fa-file-lines"></i>
                            </div>
                        @endif

                        <a href="{{ route('memories.show', $memory->id) }}" class="block group">
                            <h5 class="font-bold text-slate-800 text-xs md:text-sm leading-snug group-hover:text-indigo-600 transition-colors line-clamp-1">
                                {{ $memory->title }}
                            </h5>
                        </a>
                        
                        <p class="text-[11px] text-slate-400 font-medium mt-1 mb-2 line-clamp-2">
                            {{ $memory->description }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between border-t border-slate-50/60 pt-3 mt-1">
                        <span class="text-[10px] font-bold text-slate-400 flex items-center gap-1">
                            <i class="fa-regular fa-calendar text-[9px]"></i> 
                            {{ $memory->created_at ? $memory->created_at->format('M d, Y') : 'Recent' }}
                        </span>
                        <a href="{{ route('memories.show', $memory->id) }}" class="text-[10px] font-bold text-indigo-500 hover:text-indigo-700 transition-colors">
                            Details <i class="fa-solid fa-angle-right text-[8px]"></i>
                        </a>
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
@endsection