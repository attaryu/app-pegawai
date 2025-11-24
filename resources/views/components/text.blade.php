@props(['as' => 'p', 'variant' => null, 'class' => ''])

@php
    $baseClasses = [
        'h1' => 'text-5xl font-extrabold leading-tight tracking-tight text-gray-900 dark:text-white',
        'h2' => 'text-4xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white',
        'h3' => 'text-3xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white',
        'h4' => 'text-2xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white',
        'p' => 'text-base font-normal leading-relaxed text-gray-700 dark:text-gray-400',
        'small' => 'text-sm font-normal leading-relaxed text-gray-600 dark:text-gray-500',
    ];

    $styleVariant = $variant ?? $as;
    $classes = $baseClasses[$styleVariant] ?? $baseClasses['p'];
    $finalClass = trim("$classes $class");
@endphp

@if($as === 'h1')
    <h1 {{ $attributes->merge(['class' => $finalClass]) }}>
        {{ $slot }}
    </h1>
@elseif($as === 'h2')
    <h2 {{ $attributes->merge(['class' => $finalClass]) }}>
        {{ $slot }}
    </h2>
@elseif($as === 'h3')
    <h3 {{ $attributes->merge(['class' => $finalClass]) }}>
        {{ $slot }}
    </h3>
@elseif($as === 'h4')
    <h4 {{ $attributes->merge(['class' => $finalClass]) }}>
        {{ $slot }}
    </h4>
@elseif($as === 'small')
    <small {{ $attributes->merge(['class' => $finalClass]) }}>
        {{ $slot }}
    </small>
@else
    <p {{ $attributes->merge(['class' => $finalClass]) }}>
        {{ $slot }}
    </p>
@endif
