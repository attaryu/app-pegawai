@props(['id' => 'tooltip-default'])

<div id="{{ $id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-dark rounded-base shadow-xs opacity-0 tooltip">
    {{ $slot }}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
