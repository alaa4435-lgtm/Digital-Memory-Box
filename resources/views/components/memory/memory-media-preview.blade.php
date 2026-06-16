@props(['item', 'title'])

<div class="w-full h-full flex-shrink-0 flex items-center justify-center relative select-none">
    
    @if ($item->media_type == 'image')
        {{-- غبش خلفي سينمائي لتعبئة الفراغات --}}
        <div class="absolute inset-0 bg-cover bg-center scale-110 blur-2xl opacity-35" style="background-image: url('{{ asset('storage/' . $item->media_path) }}')"></div>
        <img src="{{ asset('storage/' . $item->media_path) }}" alt="{{ $title }}"
             class="object-contain w-full h-full z-10 relative">
            
    @elseif($item->media_type == 'audio')
        <div class="w-full h-full flex flex-col items-center justify-center p-8 bg-gradient-to-b from-slate-900 to-slate-950 z-10">
            <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center mb-6 shadow-xl">
                <i class="fa-solid fa-microphone-lines text-2xl text-indigo-400 animate-pulse"></i>
            </div>
            <audio src="{{ asset('storage/' . $item->media_path) }}" controls class="w-3/4 max-w-xs h-10 opacity-90"></audio>
        </div>
    @else
        <video src="{{ asset('storage/' . $item->media_path) }}" controls class="w-full h-full object-contain z-10 relative"></video>
    @endif

</div>