@props(['name', 'label', 'value' => '', 'rows' => '6', 'placeholder' => ''])

<div>
    @if($label)
        <label class="block font-semibold text-slate-700 text-sm mb-3">
            {{ $label }}
        </label>
    @endif

    <textarea name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
              {{ $attributes->merge(['class' => 'w-full bg-slate-50/50 border border-slate-200/60 rounded-xl p-4 text-sm outline-none focus:border-indigo-400 focus:bg-white transition-all placeholder-slate-300 resize-none']) }}>{{ old($name, $value) }}</textarea>

    @error($name)
        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
    @enderror
</div>