@props(['class' => ''])

<thead {{ $attributes->merge(['class' => "text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default $class"]) }}>
    <tr>
        {{ $slot }}
    </tr>
</thead>
