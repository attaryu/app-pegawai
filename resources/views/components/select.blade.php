@props(['label' => '', 'id' => '', 'name' => '', 'placeholder' => 'Choose an option', 'required' => false, 'value' => '', 'options' => [], 'error' => ''])

@php
    $selectId = $id ?: $name;
    $selectClasses = 'block w-full px-3 py-2.5 bg-neutral-secondary-medium border text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs';
    $borderClass = $error ? 'border-danger' : 'border-default-medium';
@endphp

<div {{ $attributes->merge(['class' => '']) }}>
    @if($label)
        <label for="{{ $selectId }}" class="block mb-2.5 text-sm font-medium text-heading">
            {{ $label }}
        </label>
    @endif

    <select
        id="{{ $selectId }}"
        name="{{ $name }}"
        class="{{ $selectClasses }} {{ $borderClass }}"
        {{ $required ? 'required' : '' }}
    >
        @if($placeholder)
            <option value="" {{ !old($name, $value) ? 'selected' : '' }} disabled>{{ $placeholder }}</option>
        @endif

        @if($slot->isEmpty())
            {{-- Jika menggunakan options array --}}
            @foreach($options as $optionValue => $optionLabel)
                <option
                    value="{{ $optionValue }}"
                    {{ old($name, $value) == $optionValue ? 'selected' : '' }}
                >
                    {{ $optionLabel }}
                </option>
            @endforeach
        @else
            {{-- Jika menggunakan slot untuk custom options --}}
            {{ $slot }}
        @endif
    </select>

    @error($name)
        <p class="mt-2 text-sm text-danger">{{ $message }}</p>
    @enderror

    @if($error)
        <p class="mt-2 text-sm text-danger">{{ $error }}</p>
    @endif
</div>
