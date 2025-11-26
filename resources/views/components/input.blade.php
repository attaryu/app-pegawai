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

    @if ($type == 'date')
        <div class="relative max-w-sm shrink-0 grow-0 h-fit">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                <i class="text-body fa-solid fa-calendar"></i>
            </div>
            <input datepicker id="{{ $inputId }}" type="text"
                class="block w-full ps-9 pe-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 shadow-xs placeholder:text-body"
                placeholder="{{ $placeholder == "" ? "Select date" : $placeholder }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }} name="{{ $name }}" />
        </div>
    @elseif ($type == 'textarea')
        <textarea id="{{ $inputId }}" name="{{ $name }}" rows="4"
            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body"
            placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}>{{ old($name, $value) }}</textarea>

    @else
        <input type="{{ $type }}" id="{{ $inputId }}" name="{{ $name }}" class="{{ $inputClasses }} {{ $borderClass }}"
            placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }} />
    @endif

    @error($name)
        <p class="mt-2 text-sm text-danger">{{ $message }}</p>
    @enderror

    @if($error)
        <p class="mt-2 text-sm text-danger">{{ $error }}</p>
    @endif
</div>
