@props(['title', 'paginator' => null, 'createRouteName' => null])

<div class="flex items-center gap-4">
    <x-text as="h1" variant="h3" class="mr-auto">{{ $title }}</x-text>

    @if ($paginator && $createRouteName)
        <x-pagination :$paginator />

        <x-button href="{{ route($createRouteName) }}">Tambah</x-button>
    @endif
</div>
