@props(['variant' => 'info', 'dismissible' => false, 'icon' => true])

@php
    $variants = [
        'info' => [
            'bg' => 'bg-brand-softer',
            'text' => 'text-fg-brand-strong',
            'icon' => 'fa-info-circle',
        ],
        'danger' => [
            'bg' => 'bg-danger-soft',
            'text' => 'text-fg-danger-strong',
            'icon' => 'fa-exclamation-circle',
        ],
        'success' => [
            'bg' => 'bg-success-soft',
            'text' => 'text-fg-success-strong',
            'icon' => 'fa-check-circle',
        ],
        'warning' => [
            'bg' => 'bg-warning-soft',
            'text' => 'text-fg-warning',
            'icon' => 'fa-exclamation-triangle',
        ],
        'dark' => [
            'bg' => 'bg-neutral-secondary-medium',
            'text' => 'text-heading',
            'icon' => 'fa-circle-info',
        ],
    ];

    $config = $variants[$variant] ?? $variants['info'];
    $bgClass = $config['bg'];
    $textClass = $config['text'];
    $iconClass = $config['icon'];

    $id = md5($slot);
@endphp


<div {{ $attributes->merge(['class' => "p-4 mb-4 text-sm rounded-base {$bgClass} {$textClass}"]) }} role="alert"
    id="alert-{{ $id }}">
    <div class="flex items-center {{ $dismissible ? 'justify-between' : '' }}">
        <div class="flex items-center gap-2">
            @if($icon)
                <i class="fa-solid {{ $iconClass }}"></i>
            @endif
            <div>
                {{ $slot }}
            </div>
        </div>

        @if($dismissible)
            <button type="button"
                class="ml-auto -mx-1.5 -my-1.5 rounded-base p-1.5 inline-flex items-center justify-center h-8 w-8 {{ $textClass }} hover:bg-black/10"
                data-dismiss-target="#alert-{{ $id }}" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <i class="fa-solid fa-xmark"></i>
            </button>
        @endif
    </div>
</div>