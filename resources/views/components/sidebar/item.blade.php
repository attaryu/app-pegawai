@props(['icon' => null, 'href' => null, 'route' => null, 'class' => ''])

@php
    $isActive = $route ? request()->routeIs($route) : false;

    $baseClass = "flex items-center px-2 py-1.5 rounded-base group transition-colors";
    $activeClass = $isActive
        ? "bg-neutral-tertiary text-fg-brand"
        : "text-body hover:bg-neutral-tertiary hover:text-fg-brand";

    $finalClass = "$baseClass $activeClass $class";
@endphp

<li>
    <a {{ $attributes->merge(['href' => $href, 'class' => $finalClass]) }}>
        <i class="{{ $icon }} text-lg size-5"></i>
        <span class="flex-1 ms-3 whitespace-nowrap">{{ $slot }}</span>
    </a>
</li>
