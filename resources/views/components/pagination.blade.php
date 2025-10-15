@props(['paginator'])

<div style="display: flex; align-items: center; gap: 0.5rem">
    <p style="height: fit-content; margin: 0">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
    </p>

    <a role="button" href="{{ $paginator->previousPageUrl() }}"
        style="height: 48px; width: 48px; padding: 0; display: grid; place-items: center">
        <i class="fa-solid fa-chevron-left"></i>
    </a>

    <details class="dropdown" style="margin: 0">
        <summary style="height: fit-content; padding: 8px 12px">Page {{ $paginator->currentPage() }}</summary>

        <ul style="max-height: 60dvh; overflow-y: auto;">
            @for ($page = 1; $page <= $paginator->lastPage(); $page++)
                <li>
                    <a href="{{ $paginator->url($page) }}">
                        {{ $page }}
                    </a>
                </li>
            @endfor
            </ul> </details>

            <a role="button" href="{{ $paginator->nextPageUrl() }}"
                style="height: 48px; width: 48px; padding: 0; display: grid; place-items: center">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
</div>