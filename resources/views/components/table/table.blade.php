@props(['class' => ''])

<div {{ $attributes->merge(['class' => "relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default $class"]) }}>
    <table class="w-full text-sm text-left rtl:text-right text-body">
        {{ $slot }}
    </table>
</div>
