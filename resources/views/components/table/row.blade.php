@props(['class' => ''])

<tr {{ $attributes->merge(['class' => "bg-neutral-primary border-b border-default last:border-b-0 $class"]) }}>
    {{ $slot }}
</tr>
