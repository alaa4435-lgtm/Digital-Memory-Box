@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto pt-4">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
            {{ __('memory.create_title') }}
        </h1>
        <p class="text-slate-400 text-sm mt-1">
            {{ __('memory.create_subtitle') }}
        </p>
    </div>

    <form action="{{ route('memories.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @csrf

        <div class="md:col-span-2 space-y-6">

            <div class="bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-8 shadow-sm">
                <label class="block font-semibold text-slate-700 text-sm text-left mb-3">
                    {{ __('memory.upload_media') }}
                </label>

                <div class="border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/50 rounded-2xl p-8 transition-all cursor-pointer flex flex-col items-center justify-center group">

                    <input type="file" name="media" accept="image/*,video/*,audio/*" class="hidden" id="mediaInput" onchange="previewFile()">

                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl mb-3 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-photo-film"></i>
                    </div>

                    <p class="text-sm font-semibold text-slate-700" id="uploadStatus">
                        {{ __('memory.drag_drop') }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        {{ __('memory.file_limit') }}
                    </p>

                    <button type="button" onclick="document.getElementById('mediaInput').click()"
                        class="mt-4 bg-white border border-slate-200 text-slate-700 text-xs font-bold px-4 py-2 rounded-xl shadow-sm hover:bg-slate-50 transition-colors">
                        {{ __('memory.browse_file') }}
                    </button>

                </div>

                @error('media')
                    <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-6 shadow-sm">
                <label class="block font-semibold text-slate-700 text-sm mb-3">
                    {{ __('memory.description') }}
                </label>

                <textarea name="description" rows="6"
                    placeholder="{{ __('memory.description_placeholder') }}"
                    class="w-full bg-slate-50/50 border border-slate-200/60 rounded-xl p-4 text-sm outline-none focus:border-indigo-400 focus:bg-white transition-all placeholder-slate-300 resize-none">{{ old('description') }}</textarea>

                @error('description')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        {{ __('memory.title') }}
                    </label>

                    <input type="text" name="title" value="{{ old('title') }}"
                        placeholder="{{ __('memory.title_placeholder') }}"
                        class="w-full bg-slate-50/50 border border-slate-200/60 rounded-xl p-3 text-sm outline-none focus:border-indigo-400 focus:bg-white transition-all">

                    @error('title')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm py-3.5 rounded-xl shadow-lg shadow-indigo-100 transition-all flex items-center justify-center gap-2 transform hover:-translate-y-0.5">

                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    {{ __('memory.save') }}
                </button>

                <a href="{{ route('memories.index') }}"
                    class="w-full bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 font-semibold text-sm py-3.5 rounded-xl transition-all text-center">

                    {{ __('memory.cancel') }}
                </a>
            </div>
        </div>
    </form>
</div>

<script>
function previewFile() {
    const input = document.getElementById('mediaInput');
    const status = document.getElementById('uploadStatus');

    if(input.files.length > 0) {
        status.innerText = "Selected: " + input.files[0].name;
        status.classList.add('text-indigo-600');
    }
}
</script>
@endsection