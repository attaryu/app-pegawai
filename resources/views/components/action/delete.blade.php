@aware(['routeName', 'id'])
@props(['deleteRouteName', 'id'])

<form action="{{ route(isset($routeName) ? $routeName . '.destroy' : $deleteRouteName, $id) }}" method="POST" style="display: inline">
    @method('DELETE')
    @csrf

    <button type="submit" role="link" class="outline" onclick="return confirm('Yakin ingin menghapus?')" style="padding: 4px; width: 40px; height: 40px; margin: 0; color: oklch(63.7% 0.237 25.331); border-color: oklch(63.7% 0.237 25.331)">
        <i class="fa-solid fa-sm fa-trash-can"></i>
    </button>
</form>