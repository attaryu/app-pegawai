@props(['icon' => null, 'href' => null, 'class' => ''])

@php
    $finalClass = "flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group $class";
@endphp

<li>
    <a {{ $attributes->merge(['href' => $href, 'class' => $finalClass]) }}>
        <i class="{{ $icon }} text-lg"></i>
        <span class="flex-1 ms-3 whitespace-nowrap">{{ $slot }}</span>
    </a>
</li>
