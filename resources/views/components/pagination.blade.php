@props(['paginator'])

<div class="flex items-center gap-4">
    <x-text as="p" style="height: fit-content; margin: 0">Halaman {{ $paginator->currentPage() }} dari
        {{ $paginator->lastPage() }}
    </x-text>

    <div class="flex items-center gap-2">
        <x-button variant="secondary" href="{{ $paginator->previousPageUrl() }}" :isIcon="true" size="lg">
            <i class="fa-solid fa-chevron-left"></i>
        </x-button>


        <x-button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" variant="secondary"
            class="flex items-center gap-10">
            Page {{ $paginator->currentPage() }}

            <i class="fa-solid fa-chevron-down ml-2"></i>
        </x-button>

        <x-button variant="secondary" href="{{ $paginator->nextPageUrl() }}" :isIcon="true" size="lg">
            <i class="fa-solid fa-chevron-right"></i>
        </x-button>
    </div>
</div>

{{-- Dropdown menu --}}
<div id="dropdown"
    class="z-10 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44">
    <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownDefaultButton">
        @for ($page = 1; $page <= $paginator->lastPage(); $page++)
            <li>
                <a href="{{ $paginator->url($page) }}"
                    class="block px-4 py-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded text-body">
                    {{ $page }}
                </a>
            </li>
        @endfor
    </ul>
</div>
