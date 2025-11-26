
@props(['variant' => 'brand', 'class' => ''])

@php
    $baseClasses = 'text-xs font-medium px-1.5 py-0.5 rounded';

    $variantClasses = [
        'brand' => 'bg-brand-softer text-fg-brand-strong',
        'alternative' => 'bg-neutral-primary-soft text-heading',
        'gray' => 'bg-neutral-secondary-medium text-heading',
        'danger' => 'bg-danger-soft text-fg-danger-strong',
        'success' => 'bg-success-soft text-fg-success-strong',
        'warning' => 'bg-warning-soft text-fg-warning',
    ];

    $variantClass = $variantClasses[$variant] ?? $variantClasses['brand'];
    $finalClass = trim("$baseClasses $variantClass $class");
@endphp

<span {{ $attributes->twMerge([$finalClass]) }}>
    {{ $slot }}
</span>
