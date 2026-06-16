@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto pt-8 pb-16 px-4 sm:px-0 space-y-6">

    {{-- Header --}}
    <div class="px-1 flex flex-col">
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight leading-none">
            {{ __('home.profile') }}
        </h1>
        <p class="text-xs text-slate-400 font-medium mt-1.5">
            Manage your account settings, cover banner, and profile identity.
        </p>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs px-4 py-3.5 rounded-2xl flex items-center gap-2 font-medium shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-500"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Profile Container Card --}}
    <div class="bg-white border border-slate-200/60 rounded-3xl shadow-sm overflow-hidden">

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="m-0">
            @csrf

            {{-- 1. COVER BANNER SECTION --}}
            <label class="block relative h-36 cursor-pointer group bg-slate-100 overflow-hidden">
                <input type="file" name="background_image" accept="image/*" class="hidden"
                    onchange="previewImage(this, 'coverPreview', 'coverPlaceholder')">

                {{-- Image element (Hidden by default if no image exists to avoid broken image icon) --}}
                <img id="coverPreview" 
                     src="{{ $user->background_image ? asset('storage/'.$user->background_image) : '' }}"
                     class="w-full h-full object-cover transition-all duration-200 group-hover:brightness-90 {{ $user->background_image ? '' : 'hidden' }}">

                {{-- Dynamic Placeholder if image doesn't exist --}}
                <div id="coverPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 text-xs gap-1.5 bg-gradient-to-br from-slate-50 to-slate-100 {{ $user->background_image ? 'hidden' : '' }}">
                    <i class="fa-regular fa-image text-lg"></i>
                    <span>Click to upload cover</span>
                </div>

                {{-- Hover Overlay --}}
                <div class="absolute inset-0 bg-slate-950/30 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-medium backdrop-blur-[1px] transition-all duration-200">
                    <span class="bg-slate-900/40 px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-white/10">
                        <i class="fa-solid fa-camera"></i> Change Cover
                    </span>
                </div>
            </label>

            {{-- 2. AVATAR SECTION --}}
            <div class="relative -mt-12 ml-6 z-10 inline-block">
                <label class="block w-24 h-24 rounded-full border-4 border-white shadow-sm overflow-hidden cursor-pointer bg-white group relative">
                    <input type="file" name="avatar" accept="image/*" class="hidden"
                        onchange="previewImage(this, 'avatarPreview', 'avatarPlaceholder')">

                    {{-- Avatar Image --}}
                    <img id="avatarPreview" 
                         src="{{ $user->avatar ? asset('storage/'.$user->avatar) : '' }}"
                         class="w-full h-full object-cover {{ $user->avatar ? '' : 'hidden' }}">

                    {{-- Initials Placeholder --}}
                    <div id="avatarPlaceholder" class="w-full h-full flex items-center justify-center text-2xl font-bold bg-slate-100 text-slate-600 select-none {{ $user->avatar ? 'hidden' : '' }}">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </div>

                    {{-- Hover Camera Badge --}}
                    <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs transition-all duration-200">
                        <i class="fa-solid fa-pen"></i>
                    </div>
                </label>
            </div>

            {{-- 3. INPUT FIELDS SECTION --}}
            <div class="px-6 pt-6 pb-6 space-y-4">
                
                {{-- Name Field --}}
                <div class="space-y-1">
                    <label for="name" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Full Name</label>
                    <input type="text" name="name" id="name" required
                        value="{{ old('name', $user->name) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition-all">
                    @error('name')
                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Field --}}
                <div class="space-y-1">
                    <label for="email" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Email Address</label>
                    <input type="email" name="email" id="email" required
                        value="{{ old('email', $user->email) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition-all">
                    @error('email')
                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Row --}}
                <div class="flex items-center justify-end border-t border-slate-100 pt-4 mt-6">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-semibold text-xs px-5 py-2.5 rounded-xl shadow-sm shadow-indigo-100 transition-all cursor-pointer flex items-center gap-1.5">
                        <i class="fa-regular fa-floppy-disk"></i>
                        Save Changes
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

{{-- 4. LIVE JAVASCRIPT PREVIEW SCRIPT --}}
<script>
    function previewImage(input, previewId, placeholderId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewImg = document.getElementById(previewId);
                const placeholderDiv = document.getElementById(placeholderId);
                
                // عرض الصورة وإخفاء الـ Placeholder التابع لها
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                if (placeholderDiv) {
                    placeholderDiv.classList.add('hidden');
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection