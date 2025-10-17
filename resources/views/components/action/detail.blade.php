@aware(['routeName', 'id'])
@props(['detailRouteName', 'id'])

<a role="button" href="{{ route($detailRouteName ?? $routeName . '.show', $id) }}"
    class="outline"
    style="padding: 4px; width: 40px; height: 40px; border-color: oklch(62.3% 0.214 259.815); color: oklch(62.3% 0.214 259.815);">
    <i class="fa-solid fa-sm fa-info"></i>
</a>
