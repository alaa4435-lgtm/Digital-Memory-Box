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
            <div class="bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-8 shadow-sm space-y-4">
                <label class="block font-semibold text-slate-700 text-sm text-left mb-1">
                    {{ __('memory.upload_media') }}
                </label>

                {{-- استدعاء كامبوننت الرفع المشترك --}}
                <x-memory.memory-uploader statusId="uploadStatus" :isEdit="false" />

                {{-- حاوية عرض الميديا المعاينة قبل الرفع --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4" id="new-media-preview-container"></div>

                @error('media')
                    <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>
                @enderror
                @error('media.*')
                    <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- استدعاء كامبوننت النص الكبير للوصف --}}
            <div class="bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-6 shadow-sm">
                <x-form.textarea name="description" :label="__('memory.description')" :placeholder="__('memory.description_placeholder')" rows="6" />
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white/70 backdrop-blur-md border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                {{-- استدعاء كامبوننت الإدخال للعنوان --}}
                <x-form.input name="title" :label="__('memory.title')" :placeholder="__('memory.title_placeholder')" type="text" />

                <div class="pt-2">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm p-4 rounded-2xl shadow-md shadow-indigo-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> {{ __('memory.save') }}
                    </button>
                    <a href="{{ route('memories.index') }}" class="w-full mt-2 bg-white border border-slate-200 text-slate-500 hover:text-slate-700 font-semibold text-xs p-3.5 rounded-2xl shadow-sm transition-all flex items-center justify-center">
                        {{ __('memory.cancel') }}
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- سكريبت إدارة الملفات الجديدة المتعددة المتطورة ونقلها إلى Input بشكل نظيف --}}
<script>
let newFilesArray = [];

function previewNewFiles(input) {
    const container = document.getElementById('new-media-preview-container');
    if (!input.files || input.files.length === 0) return;

    const files = Array.from(input.files);
    
    files.forEach(file => {
        const fileId = Date.now() + Math.random().toString(36).substr(2, 9);
        newFilesArray.push({ id: fileId, file: file });

        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.className = "relative rounded-2xl overflow-hidden bg-slate-100 border border-slate-200/60 shadow-inner flex flex-col justify-between group/item animate-fadeIn";
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
    const element = document.getElementById(`new-media-wrapper-${fileId}`);
    if (element) element.remove();
    updateStatusAndInput();
}

function updateStatusAndInput() {
    	const status = document.getElementById('uploadStatus');
    	const mainInput = document.getElementById('mediaInput');
    	
    	if (newFilesArray.length > 0) {
    		status.innerText = "{{ __('memory.file_selected_prefix') }}" + newFilesArray.length + " {{ __('memory.files') }}";
    		status.classList.add('text-indigo-600');
    	} else {
    		status.innerText = "{{ __('memory.drag_drop') }}";
    		status.classList.remove('text-indigo-600');
    	}

    const dataTransfer = new DataTransfer();
    newFilesArray.forEach(item => dataTransfer.items.add(item.file));
    mainInput.files = dataTransfer.files;
}
</script>
@endsection