@props([
    'range' => false,
    'label' => '',
    'startName' => 'start_date',
    'endName' => 'end_date',
    'name' => 'date',
    'id' => '',
    'placeholder' => 'Select date',
    'startPlaceholder' => 'Select start date',
    'endPlaceholder' => 'Select end date',
    'required' => false,
    'value' => '',
    'startValue' => '',
    'endValue' => '',
    'error' => '',
    'startError' => '',
    'endError' => '',
])

@php
    $inputId = $id ?: $name;
    $inputClasses = 'block w-full ps-9 pe-3 py-2.5 bg-neutral-secondary-medium border text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body';
    $borderClass = $error ? 'border-danger' : 'border-default-medium';
    $startBorderClass = $startError ? 'border-danger' : 'border-default-medium';
    $endBorderClass = $endError ? 'border-danger' : 'border-default-medium';
@endphp

<div {{ $attributes->merge(['class' => '']) }}>
    @if($label)
        <label class="block mb-2.5 text-sm font-medium text-heading">
            {{ $label }}
        </label>
    @endif  

    @if($range)
        {{-- Range Date Picker --}}
        <div id="date-range-picker-{{ $inputId }}" date-rangepicker class="flex items-center" datepicker-format="yyyy-mm-dd">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <i class="text-body fa-solid fa-calendar"></i>
                </div>
                
                <input 
                    id="{{ $inputId }}-start" 
                    name="{{ $startName }}" 
                    type="text"
                    class="{{ $inputClasses }} {{ $startBorderClass }}"
                    placeholder="{{ $startPlaceholder }}" 
                    value="{{ old($startName, $startValue) }}"
                    {{ $required ? 'required' : '' }}
                >
            </div>

            <span class="mx-4 text-body">to</span>

            <div class="relative flex-1">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <i class="text-body fa-solid fa-calendar"></i>
                </div>
                <input 
                    id="{{ $inputId }}-end" 
                    name="{{ $endName }}" 
                    type="text"
                    class="{{ $inputClasses }} {{ $endBorderClass }}"
                    placeholder="{{ $endPlaceholder }}" 
                    value="{{ old($endName, $endValue) }}"
                    {{ $required ? 'required' : '' }}
                >
            </div>
        </div>

        @if($startError || $endError)
            <div class="mt-2 space-y-1">
                @if($startError)
                    <p class="text-sm text-danger">Start: {{ $startError }}</p>
                @endif
                @if($endError)
                    <p class="text-sm text-danger">End: {{ $endError }}</p>
                @endif
            </div>
        @endif
    @else
        {{-- Single Date Picker --}}
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                <i class="text-body fa-solid fa-calendar"></i>
            </div>
            <input 
                datepicker 
                datepicker-format="yyyy-mm-dd"
                id="{{ $inputId }}" 
                name="{{ $name }}"
                type="text"
                class="{{ $inputClasses }} {{ $borderClass }}"
                placeholder="{{ $placeholder }}" 
                value="{{ old($name, $value) }}" 
                {{ $required ? 'required' : '' }}
            >
        </div>

        @if($error)
            <p class="mt-2 text-sm text-danger">{{ $error }}</p>
        @endif
    @endif
</div>