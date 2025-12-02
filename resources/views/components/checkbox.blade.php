@props(['id' => '', 'name' => '', 'label' => '', 'value' => '1', 'checked' => false])

<div class="flex items-center">
    <input id="{{ $id }}" name="{{ $name }}" type="checkbox" value="{{ $value }}" {{ $checked ? 'checked' : '' }} class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
    <label for="{{ $id }}" class="select-none ms-2 text-sm font-medium text-heading">{{ $label }}</label>
</div>
