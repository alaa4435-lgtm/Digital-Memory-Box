@props(['name', 'label', 'value' => '', 'type' => 'text', 'placeholder' => ''])

<div>
    @if($label)
        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
            {{ $label }}
        </label>
    @endif

    <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}"
           {{ $attributes->merge(['class' => 'w-full bg-slate-50/50 border border-slate-200/60 rounded-xl p-3 text-sm outline-none focus:border-indigo-400 focus:bg-white transition-all']) }}>

    @error($name)
        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
    @enderror
</div>