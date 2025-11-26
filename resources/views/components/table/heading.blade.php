@props(['class' => ''])

<th {{ $attributes->merge(['scope' => 'col', 'class' => "px-6 py-3 font-medium $class"]) }}>
    {{ $slot }}
</th>
