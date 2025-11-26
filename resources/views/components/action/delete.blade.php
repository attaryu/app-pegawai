@aware(['routeName', 'id'])
@props(['deleteRouteName', 'id'])

<form action="{{ route($deleteRouteName ?? $routeName . '.destroy', $id) }}" method="POST" style="display: inline">
    @method('DELETE')
    @csrf

    <x-button type="button" variant="danger" :isIcon="true" data-modal-target="delete-confirmation"
        data-modal-toggle="delete-confirmation">
        <i class="fa-solid fa-trash-can"></i>
    </x-button>

    {{-- Modal --}}
    <div id="delete-confirmation" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            {{-- Modal content --}}
            <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
                {{-- Modal header --}}
                <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                    <h3 class="text-lg font-medium text-heading">
                        Delete Confirmation
                    </h3>

                    <button type="button"
                        class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="delete-confirmation">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                {{-- Modal body --}}
                <div class="space-y-4 md:space-y-6 py-4 md:py-6">
                    <p class="leading-relaxed text-body">
                        Are you sure you want to delete this item? This action cannot be undone.
                    </p>
                </div>

                {{-- Modal footer --}}
                <div class="flex items-center border-t border-default space-x-4 pt-4 md:pt-5">
                    <x-button type="submit" variant="danger" onclick="return confirm('Yakin ingin menghapus?')">
                        Yes, I'm sure
                    </x-button>
                    <button data-modal-hide="delete-confirmation" type="button"
                        class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                        Decline
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
