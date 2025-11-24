@props(['label' => '', 'id' => '', 'name' => '', 'type' => 'text', 'placeholder' => '', 'required' => false, 'value' => '', 'error' => ''])

@php
    $inputId = $id ?: $name;
    $inputClasses = 'bg-neutral-secondary-medium border text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body';
    $borderClass = $error ? 'border-danger' : 'border-default-medium';
@endphp

<div {{ $attributes->merge(['class' => '']) }}>
    @if($label)
        <label for="{{ $inputId }}" class="block mb-2.5 text-sm font-medium text-heading">
            {{ $label }}
        </label>
    @endif

    <input type="{{ $type }}" id="{{ $inputId }}" name="{{ $name }}" class="{{ $inputClasses }} {{ $borderClass }}"
        placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }} />

    @error($name)
        <p class="mt-2 text-sm text-danger">{{ $message }}</p>
    @enderror

    @if($error)
        <p class="mt-2 text-sm text-danger">{{ $error }}</p>
    @endif
</div>
