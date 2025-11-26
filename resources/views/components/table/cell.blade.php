@props(['header' => false, 'class' => ''])

@if($header)
    <th {{ $attributes->merge(['scope' => 'row', 'class' => "px-6 py-4 font-medium text-heading whitespace-nowrap $class"]) }}>
        {{ $slot }}
    </th>
@else
    <td {{ $attributes->merge(['class' => "px-6 py-4 $class"]) }}>
        {{ $slot }}
    </td>
@endif
