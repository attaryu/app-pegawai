@props([
    'id' => 'modal-' . uniqid(),
    'title' => null,
    'icon' => null,
    'iconColor' => 'text-fg-disabled',
    'size' => 'md',
    'centered' => true,
])

@php
    $sizeClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ];
    $maxWidth = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div id="{{ $id }}" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full {{ $maxWidth }} max-h-full">
        <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm">
            {{-- Close button --}}
            <button type="button" class="absolute top-3 right-3 text-body-secondary hover:text-heading rounded-base p-1.5" data-modal-hide="{{ $id }}">
                <i class="fa-solid fa-times"></i>
                <span class="sr-only">Close modal</span>
            </button>

            <div class="p-4 md:p-6 {{ $centered ? 'text-center' : '' }}">
                @if($icon)
                    <i class="fa-solid {{ $icon }} {{ $centered ? 'mx-auto' : '' }} mb-4 {{ $iconColor }} text-4xl block"></i>
                @endif

                @if($title)
                    <x-text as="h3" variant="h4" class="mb-4">{{ $title }}</x-text>
                @endif

                <div class="{{ $centered ? '' : 'text-left' }}">
                    {{ $slot }}
                </div>

                @isset($actions)
                    <div class="flex items-center gap-4 {{ $centered ? 'justify-center' : 'justify-end' }} mt-6">
                        {{ $actions }}
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>
