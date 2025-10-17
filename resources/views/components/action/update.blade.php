@aware(['routeName', 'id'])
@props(['updateRouteName', 'id'])

<a role="button" href="{{ route($updateRouteName ?? $routeName . '.edit', $id) }}"
    style="padding: 4px; width: 40px; height: 40px;">
    <i class="fa-solid fa-sm fa-pen-to-square"></i>
</a>
