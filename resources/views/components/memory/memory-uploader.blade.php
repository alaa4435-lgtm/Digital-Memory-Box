@props(['statusId' => 'uploadStatus', 'isEdit' => false])

<div onclick="document.getElementById('mediaInput').click()" 
     class="border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/50 rounded-2xl p-8 transition-all cursor-pointer flex flex-col items-center justify-center group">

    <input type="file" name="media[]" accept="image/*,video/*,audio/*" class="hidden" id="mediaInput" onchange="previewNewFiles(this)" multiple>

    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl mb-3 group-hover:scale-110 transition-transform">
        <i class="fa-solid {{ $isEdit ? 'fa-plus' : 'fa-photo-film' }}"></i>
    </div>

    <p class="text-sm font-semibold text-slate-700" id="{{ $statusId }}">
        {{ $isEdit ? __('memory.add_more_media') : __('memory.drag_drop') }}
    </p>

    @if(!$isEdit)
        <p class="text-xs text-slate-400 mt-1">
            {{ __('memory.file_limit') }}
        </p>
    @endif

    <button type="button" class="mt-4 bg-white border border-slate-200 text-slate-700 text-xs font-bold px-4 py-2 rounded-xl shadow-sm hover:bg-slate-50 transition-colors">
        {{ __('memory.browse_file') }}
    </button>
</div>