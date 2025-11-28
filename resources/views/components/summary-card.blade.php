@props([
    'label' => 'Label',
    'highlight' => 'Highlight',
    'small' => null,
    'icon' => 'fa-users',
])

@php
    $id = 'tooltip-' . Str::slug($label);
@endphp

<x-card class="hover:shadow-lg transition-shadow flex flex-col gap-2" data-tooltip-target="{{ $id }}">
    <x-text as="small" class="text-body-secondary">{{ $label }}</x-text>

    <div class="flex items-center justify-between">
        <x-text as="h2" variant="h4" class="truncate w-4/5">{{ $highlight }}</x-text>

        <i class="fa-solid {{ $icon }} text-body text-2xl"></i>
    </div>

    @if ($small)
        <x-text as="small" class="text-success">
            {{ $small }}
        </x-text>
    @endif
</x-card>

<x-tooltip id="{{ $id }}">
    {{ $label }}: {{ $highlight }}
</x-tooltip>
