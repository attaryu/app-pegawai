@props(['title', 'paginator' => null, 'createRouteName' => null])

<div style="display: flex; align-items: center; gap: 0.5rem; margin: 3rem 0 1rem">
    <hgroup style="margin-right: auto">
        <h1>{{ $title }}</h1>
    </hgroup>

    @if ($paginator && $createRouteName)
        <x-pagination :$paginator />

        <a href="{{ route($createRouteName) }}" role="button" style="height: fit-content; padding: 8px 12px">Tambah</a>
    @endif
</div>