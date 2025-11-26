@props(['class' => ''])

<div {{ $attributes->twMerge(["w-full bg-neutral-primary-soft p-6 border border-default rounded-base shadow-xs", $class]) }}>
    {{ $slot }}
</div>
