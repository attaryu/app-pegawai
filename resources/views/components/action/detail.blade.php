@aware(['routeName', 'id'])
@props(['detailRouteName', 'id'])

<x-button href="{{ route($detailRouteName ?? $routeName . '.show', $id) }}" variant="primary" :isIcon="true">
    <i class="fa-solid fa-info"></i>
</x-button>
