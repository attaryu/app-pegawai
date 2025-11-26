@props(['variant' => 'default', 'type' => 'button', 'href' => null, 'isIcon' => false, 'size' => 'md', 'class' => ''])

@php
    // Base classes untuk text button
    $textBaseClasses = 'inline-block box-border font-medium leading-5 rounded-base text-sm focus:outline-none shadow-xs text-center';

    // Base classes untuk icon button
    $iconBaseClasses = 'inline-flex items-center justify-center focus:outline-none shadow-xs rounded-base';

    // Size untuk text button
    $textSizeClasses = [
        'sm' => 'px-3 py-2 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-5 py-3 text-base',
    ];

    // Size untuk icon button
    $iconSizeClasses = [
        'sm' => 'w-8 h-8',
        'md' => 'w-9 h-9',
        'lg' => 'w-10 h-10',
    ];

    // Variant classes
    $variantClasses = [
        'default' => 'text-white bg-brand border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium',
        'default-outline' => 'text-fg-brand bg-neutral-primary border border-brand hover:bg-brand hover:text-white focus:ring-4 focus:ring-brand-subtle',
        'secondary' => 'text-body bg-neutral-secondary-medium border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary',
        'tertiary' => 'text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary-soft',
        'success' => 'text-white bg-success border border-transparent hover:bg-success-strong focus:ring-4 focus:ring-success-medium',
        'danger' => 'text-white bg-danger border border-transparent hover:bg-danger-strong focus:ring-4 focus:ring-danger-medium',
        'warning' => 'text-white bg-warning border border-transparent hover:bg-warning-strong focus:ring-4 focus:ring-warning-medium',
        'dark' => 'text-white bg-dark border border-transparent hover:bg-dark-strong focus:ring-4 focus:ring-neutral-tertiary',
        'ghost' => 'text-heading bg-transparent border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary',
    ];

    // Build final classes
    $baseClass = $isIcon ? $iconBaseClasses : $textBaseClasses;
    $sizeClass = $isIcon ? ($iconSizeClasses[$size] ?? $iconSizeClasses['md']) : ($textSizeClasses[$size] ?? $textSizeClasses['md']);
    $variantClass = $variantClasses[$variant] ?? $variantClasses['default'];
    $finalClass = trim("$baseClass $sizeClass $variantClass $class");
@endphp

@if($href)
    <a {{ $attributes->merge(['href' => $href, 'class' => $finalClass]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => $type, 'class' => $finalClass])}}>
        {{ $slot }}
    </button>
@endif
