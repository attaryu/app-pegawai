@aware(['routeName', 'id'])
@props(['updateRouteName', 'id'])

<x-button href="{{ route($updateRouteName ?? $routeName . '.edit', $id) }}"
    variant="tertiary" :isIcon="true">
    <i class="fa-solid fa-pen-to-square"></i>
</x-button>
