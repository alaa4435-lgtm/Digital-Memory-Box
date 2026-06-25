@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto pt-4">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
            {{ __('memory.edit_title') }}
        </h1>
        <p class="text-slate-400 text-sm mt-1">
            {{ __('memory.edit_subtitle') }}
        </p>
    </div>

    <form action="{{ route('memories.update', $memory->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @csrf
        @method('PUT')

        <div class="md:col-span-2 space-y-6">
            <div class="bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <label class="block font-semibold text-slate-700 text-sm text-left">
                    {{ __('memory.media_label') }}
                </label>

                {{-- إدارة الميديا المرفوعة مسبقاً من السيرفر --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="existing-media-container">
                    @if($memory->media && $memory->media->count() > 0)
                        @foreach($memory->media as $item)
                            <div class="relative rounded-2xl overflow-hidden bg-slate-100 border border-slate-200/60 shadow-inner flex flex-col justify-between" id="media-wrapper-{{ $item->id }}">
                                <div class="max-h-40 flex items-center justify-center overflow-hidden bg-black/5 flex-grow">
                                    @if($item->media_type == 'image')
                                        <img src="{{ asset('storage/' . $item->media_path) }}" class="object-cover h-40 w-full" id="preview-img-{{ $item->id }}">
                                    @elseif($item->media_type == 'audio')
                                        <div class="p-4 text-center w-full bg-slate-50 flex flex-col items-center justify-center h-40" id="preview-audio-{{ $item->id }}">
                                            <i class="fa-solid fa-volume-high text-3xl text-indigo-500 mb-1"></i>
                                            <p class="text-[10px] text-slate-500">{{ __('memory.audio_file') }}</p>
                                        </div>
                                    @else
                                        <video src="{{ asset('storage/' . $item->media_path) }}" class="max-h-40 w-full object-cover" controls id="preview-video-{{ $item->id }}"></video>
                                    @endif
                                </div>

                                <div class="p-2 bg-white border-t border-slate-100 flex gap-2 justify-between items-center">
                                    <button type="button" onclick="triggerReplace({{ $item->id }})" class="flex-1 py-1 px-2 text-[11px] font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-arrows-rotate"></i> {{ __('memory.replace_media') }}
                                    </button>
                                    <button type="button" onclick="markAsDeleted({{ $item->id }})" class="py-1 px-2 text-[11px] font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-trash-can"></i> {{ __('memory.delete_media') }}
                                    </button>
                                </div>

                                <input type="hidden" name="deleted_media[]" id="delete-input-{{ $item->id }}" value="">
                                <input type="file" name="replaced_media[{{ $item->id }}]" id="replace-input-{{ $item->id }}" class="hidden" accept="image/*,video/*,audio/*" onchange="previewReplacement(this, {{ $item->id }})">
                            </div>
                        @endforeach
                    @endif
                </div>

                {{-- استدعاء كامبوننت الرفع المشترك لإضافة المزيد --}}
                <x-memory.memory-uploader statusId="editUploadStatus" :isEdit="true" />

                {{-- حاوية الملفات الجديدة الإضافية --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4" id="new-media-preview-container"></div>

                @error('media') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                @error('media.*') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
            </div>

            {{-- استدعاء كامبوننت الوصف بقيمته الحالية --}}
            <div class="bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-6 shadow-sm">
                <x-form.textarea name="description" :label="__('memory.description')" :value="$memory->description" rows="6" />
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                {{-- استدعاء كامبوننت حقل الإدخال للعنوان بقيمته الحالية --}}
                <x-form.input name="title" :label="__('memory.title')" :value="$memory->title" type="text" />

                <div class="pt-2">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm p-4 rounded-2xl shadow-md shadow-indigo-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-check mr-1.5"></i> {{ __('memory.save_changes') }}
                    </button>
                    <a href="{{ route('memories.index') }}" class="w-full mt-2 bg-white border border-slate-200 text-slate-500 hover:text-slate-700 font-semibold text-xs p-3.5 rounded-2xl shadow-sm transition-all flex items-center justify-center">
                        {{ __('memory.cancel') }}
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let newFilesArray = [];

function triggerReplace(id) {
    document.getElementById(`replace-input-${id}`).click();
}

function markAsDeleted(id) {
    const wrapper = document.getElementById(`media-wrapper-${id}`);
    const deleteInput = document.getElementById(`delete-input-${id}`);
    deleteInput.value = id;
    wrapper.style.opacity = '0.3';
    wrapper.style.pointerEvents = 'none';
}

function previewReplacement(input, id) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            if (file.type.startsWith('image/')) {
                const img = document.getElementById(`preview-img-${id}`);
                if (img) img.src = e.target.result;
            } else if (file.type.startsWith('video/')) {
                const video = document.getElementById(`preview-video-${id}`);
                if (video) video.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
}

function previewNewFiles(input) {
    const container = document.getElementById('new-media-preview-container');
    if (!input.files || input.files.length === 0) return;

    Array.from(input.files).forEach(file => {
        const fileId = Date.now() + Math.random().toString(36).substr(2, 9);
        newFilesArray.push({ id: fileId, file: file });

        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.className = "relative rounded-2xl overflow-hidden bg-slate-100 border border-slate-200/60 shadow-inner flex flex-col justify-between";
            wrapper.id = `new-media-wrapper-${fileId}`;

            let mediaPreview = '';
            if (file.type.startsWith('image/')) {
                mediaPreview = `<img src="${e.target.result}" class="object-cover h-40 w-full">`;
            } else if (file.type.startsWith('video/')) {
                mediaPreview = `<video src="${e.target.result}" class="max-h-40 w-full object-cover" controls></video>`;
            } else {
                mediaPreview = `<div class="p-4 text-center w-full bg-slate-50 flex flex-col items-center justify-center h-40">
                                    <i class="fa-solid fa-volume-high text-3xl text-indigo-500 mb-1"></i>
                                    <p class="text-[10px] text-slate-500">${file.name}</p>
                                </div>`;
            }

            wrapper.innerHTML = `
                <div class="max-h-40 flex items-center justify-center overflow-hidden bg-black/5 flex-grow">
                    ${mediaPreview}
                </div>
                <div class="p-2 bg-white border-t border-slate-100 flex justify-end">
                    <button type="button" onclick="removeNewFile('${fileId}')" class="w-full py-1 text-[11px] font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors flex items-center justify-center gap-1">
                        <i class="fa-solid fa-trash-can"></i> {{ __('memory.delete_media') }}
                    </button>
                </div>
            `;
            container.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
    updateStatusAndInput();
}

function removeNewFile(fileId) {
    newFilesArray = newFilesArray.filter(item => item.id !== fileId);
    document.getElementById(`new-media-wrapper-${fileId}`)?.remove();
    updateStatusAndInput();
}

function updateStatusAndInput() {
    const status = document.getElementById('editUploadStatus');
    const mainInput = document.getElementById('mediaInput');
    
    if (newFilesArray.length > 0) {
        status.innerText = "{{ __('memory.file_selected_prefix') }} " + newFilesArray.length + " {{ __('memory.files') }}";
        status.classList.add('text-indigo-600');
    } else {
        status.innerText = "{{ __('memory.add_more_media') }}";
        status.classList.remove('text-indigo-600');
    }

    const dataTransfer = new DataTransfer();
    newFilesArray.forEach(item => dataTransfer.items.add(item.file));
    mainInput.files = dataTransfer.files;
}
</script>
@endsection