@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto pt-10 pb-16 px-4 sm:px-6 lg:px-8 space-y-8">

    {{-- Header --}}
    <div class="flex flex-col space-y-1">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
            {{ __('home.profile') }}
        </h1>
        <p class="text-sm text-slate-500">
            {{ __('profile.manage_account_settings') }}
        </p>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm px-4 py-3.5 rounded-2xl flex items-center gap-3 font-medium shadow-sm transition-all animate-fade-in">
            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Profile Container Card --}}
    <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="m-0">
            @csrf

            {{-- 1. COVER BANNER SECTION --}}
            <label id="coverLabel" class="block relative h-44 bg-slate-50 overflow-hidden border-b border-slate-100 pointer-events-none group">
                <input type="file" name="background_image" id="coverInput" accept="image/*" class="hidden" disabled
                    onchange="previewImage(this, 'coverPreview', 'coverPlaceholder')">

                {{-- Image element --}}
                <img id="coverPreview" 
                     src="{{ $user->background_image ? asset('storage/'.$user->background_image) : '' }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 {{ $user->background_image ? '' : 'hidden' }}">

                {{-- Dynamic Placeholder if image doesn't exist --}}
                <div id="coverPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 text-sm gap-2 bg-gradient-to-br from-slate-50 via-slate-100/70 to-slate-200/50 {{ $user->background_image ? 'hidden' : '' }}">
                    <div class="p-3 bg-white rounded-full shadow-sm border border-slate-100 text-slate-500 transition-transform duration-300">
                        <i class="fa-regular fa-image text-xl"></i>
                    </div>
                    <span class="font-medium text-slate-600 text-xs">{{ __('profile.click_to_upload_cover') }}</span>
                </div>

                {{-- Hover Overlay --}}
                <div id="coverOverlay" class="absolute inset-0 bg-slate-900/40 opacity-0 flex items-center justify-center backdrop-blur-[2px] transition-all duration-300 hidden">
                    <span class="bg-white/95 backdrop-blur text-slate-800 px-4 py-2 rounded-xl flex items-center gap-2 text-xs font-semibold shadow-md border border-white/20">
                        <i class="fa-solid fa-camera text-slate-600"></i> {{ __('profile.change_cover') }}
                    </span>
                </div>
            </label>

            {{-- 2. AVATAR & EDIT BUTTON SECTION --}}
            <div class="relative -mt-16 px-6 sm:px-8 z-10 flex items-end justify-between gap-4">
                {{-- Avatar --}}
                <label id="avatarLabel" class="block w-28 h-28 rounded-2xl border-4 border-white shadow-md overflow-hidden bg-white relative transition-transform duration-300 pointer-events-none group shrink-0">
                    <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden" disabled
                        onchange="previewImage(this, 'avatarPreview', 'avatarPlaceholder')">

                    {{-- Avatar Image --}}
                    <img id="avatarPreview" 
                         src="{{ $user->avatar ? asset('storage/'.$user->avatar) : '' }}"
                         class="w-full h-full object-cover {{ $user->avatar ? '' : 'hidden' }}">

                    {{-- Initials Placeholder --}}
                    <div id="avatarPlaceholder" class="w-full h-full flex items-center justify-center text-3xl font-bold bg-gradient-to-br from-slate-100 to-slate-200 text-slate-700 select-none {{ $user->avatar ? 'hidden' : '' }}">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </div>

                    {{-- Hover Camera Badge --}}
                    <div id="avatarOverlay" class="absolute inset-0 bg-slate-900/50 opacity-0 flex items-center justify-center text-white text-sm transition-all duration-300 backdrop-blur-[1px] hidden">
                        <div class="p-2 bg-white/20 rounded-lg backdrop-blur">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </div>
                    </div>
                </label>


                <button type="button" id="editToggleButton" onclick="toggleEditMode()" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 hover:bg-indigo-100 active:scale-[0.98] text-indigo-700 text-xs font-bold rounded-xl shadow-sm border border-indigo-200/60 transition-all duration-200 cursor-pointer mb-0">
                    <i class="fa-solid fa-pen-to-square text-indigo-600 text-sm"></i>
                    {{ __('profile.edit_profile') }}
                </button>
            </div>

            {{-- 3. INPUT FIELDS SECTION --}}
            <div class="px-6 sm:px-8 pt-8 pb-8 space-y-6">
                
                {{-- Name Field --}}
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-semibold text-slate-700 tracking-wide">
                        {{ __('profile.full_name_label') }}
                    </label>
                    <input type="text" name="name" id="name" required readonly
                        value="{{ old('name', $user->name) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 bg-slate-50/50 outline-none transition-all duration-200 placeholder-slate-400 cursor-not-allowed">
                    @error('name')
                        <p class="text-xs text-rose-500 font-medium mt-1.5 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email Field --}}
                <div class="space-y-2">
                    <label for="email" class="block text-xs font-semibold text-slate-700 tracking-wide">
                        {{ __('profile.email_address_label') }}
                    </label>
                    <input type="email" name="email" id="email" required readonly
                        value="{{ old('email', $user->email) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 bg-slate-50/50 outline-none transition-all duration-200 placeholder-slate-400 cursor-not-allowed">
                    @error('email')
                        <p class="text-xs text-rose-500 font-medium mt-1.5 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- صف الأزرار السفلي مع الـ Localization --}}
                <div id="actionRow" class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6 mt-8 hidden">
                    <button type="button" onclick="toggleEditMode()" class="px-5 py-2.5 bg-slate-50 hover:bg-slate-100 active:scale-[0.98] text-slate-700 font-semibold text-sm rounded-xl border border-slate-200/80 transition-all duration-200 cursor-pointer">
                        {{ __('memory.cancel') }}
                    </button>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-semibold text-sm rounded-xl shadow-md shadow-indigo-100 hover:shadow-lg hover:shadow-indigo-100/40 transition-all duration-200 cursor-pointer">
                        <i class="fa-regular fa-floppy-disk text-base"></i>
                        {{ __('profile.save_changes') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

{{-- 4. LIVE JAVASCRIPT PREVIEW & TOGGLE SCRIPT --}}
<script>
    function toggleEditMode() {
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const coverInput = document.getElementById('coverInput');
        const avatarInput = document.getElementById('avatarInput');
        
        const coverLabel = document.getElementById('coverLabel');
        const avatarLabel = document.getElementById('avatarLabel');
        const coverOverlay = document.getElementById('coverOverlay');
        const avatarOverlay = document.getElementById('avatarOverlay');
        
        const editToggleButton = document.getElementById('editToggleButton');
        const actionRow = document.getElementById('actionRow');

        const isReadOnly = nameInput.hasAttribute('readonly');

        if (isReadOnly) {
            nameInput.removeAttribute('readonly');
            emailInput.removeAttribute('readonly');
            coverInput.removeAttribute('disabled');
            avatarInput.removeAttribute('disabled');

            [nameInput, emailInput].forEach(input => {
                input.classList.remove('bg-slate-50/50', 'text-slate-500', 'cursor-not-allowed');
                input.classList.add('bg-white', 'text-slate-800', 'focus:ring-4', 'focus:ring-indigo-500/5', 'focus:border-indigo-500');
            });

            coverLabel.classList.remove('pointer-events-none');
            avatarLabel.classList.remove('pointer-events-none');
            coverLabel.classList.add('cursor-pointer');
            avatarLabel.classList.add('cursor-pointer');
            coverOverlay.classList.remove('hidden');
            avatarOverlay.classList.remove('hidden');
            coverOverlay.classList.add('group-hover:opacity-100');
            avatarOverlay.classList.add('group-hover:opacity-100');

            editToggleButton.classList.add('hidden');
            actionRow.classList.remove('hidden');
            
            nameInput.focus();
        } else {
            nameInput.setAttribute('readonly', 'readonly');
            emailInput.setAttribute('readonly', 'readonly');
            coverInput.setAttribute('disabled', 'disabled');
            avatarInput.setAttribute('disabled', 'disabled');

            [nameInput, emailInput].forEach(input => {
                input.classList.add('bg-slate-50/50', 'text-slate-500', 'cursor-not-allowed');
                input.classList.remove('bg-white', 'text-slate-800', 'focus:ring-4', 'focus:ring-indigo-500/5', 'focus:border-indigo-500');
            });

            coverLabel.classList.add('pointer-events-none');
            avatarLabel.classList.add('pointer-events-none');
            coverLabel.classList.remove('cursor-pointer');
            avatarLabel.classList.remove('cursor-pointer');
            coverOverlay.classList.add('hidden');
            avatarOverlay.classList.add('hidden');
            coverOverlay.classList.remove('group-hover:opacity-100');
            avatarOverlay.classList.remove('group-hover:opacity-100');

            editToggleButton.classList.remove('hidden');
            actionRow.classList.add('hidden');
        }
    }

    function previewImage(input, previewId, placeholderId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewImg = document.getElementById(previewId);
                const placeholderDiv = document.getElementById(placeholderId);
                
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