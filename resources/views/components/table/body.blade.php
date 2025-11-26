@props(['class' => ''])

<tbody {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</tbody>
