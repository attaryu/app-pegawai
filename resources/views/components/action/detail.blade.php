@aware(['routeName', 'id'])
@props(['detailRouteName', 'id'])

<a role="button" href="{{ route(isset($routeName) ? $routeName . '.show' : $detailRouteName, $id) }}"
    style="padding: 4px; width: 40px; height: 40px;">
    <i class="fa-solid fa-sm fa-info"></i>
</a>