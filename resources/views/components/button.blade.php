@props(['variant' => 'default', 'type' => 'button', 'class' => ''])

@php
    $baseClasses = 'box-border font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none shadow-xs';

    $variantClasses = [
        'default' => 'text-white bg-brand border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium',
        'secondary' => 'text-body bg-neutral-secondary-medium border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary',
        'tertiary' => 'text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary-soft',
        'success' => 'text-white bg-success border border-transparent hover:bg-success-strong focus:ring-4 focus:ring-success-medium',
        'danger' => 'text-white bg-danger border border-transparent hover:bg-danger-strong focus:ring-4 focus:ring-danger-medium',
        'warning' => 'text-white bg-warning border border-transparent hover:bg-warning-strong focus:ring-4 focus:ring-warning-medium',
        'dark' => 'text-white bg-dark border border-transparent hover:bg-dark-strong focus:ring-4 focus:ring-neutral-tertiary',
        'ghost' => 'text-heading bg-transparent border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary',
    ];

    $variantClass = $variantClasses[$variant] ?? $variantClasses['default'];
    $finalClass = trim("$baseClasses $variantClass $class");
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $finalClass]) }}>
    {{ $slot }}
</button>
