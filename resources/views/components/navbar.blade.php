@props(['isDashboard' => false])

@php
    $user = auth()->user();
    $employee = $user?->employee;
    $role = $user?->role;

    $isAdmin = $role?->name == 'admin';

    $userProfile = $isAdmin
        ? 'https://ui-avatars.com/api/?name=admin&format=svg&background=random&font-size=0.4&bold=true'
        : 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $employee->nama_lengkap ?? 'User') . '&format=svg&background=random&font-size=0.4&bold=true';
@endphp


<nav class="bg-neutral-primary fixed w-full z-20 top-0 start-0 border-b border-default">
    <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
        <div class="flex items-center space-x-3 rtl:space-x-reverse">
            {{-- sidebar toggle button --}}
            @if ($isDashboard)
                <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar"
                    aria-controls="top-bar-sidebar" type="button"
                    class="sm:hidden text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base text-sm p-2 focus:outline-none">
                    <span class="sr-only">Open sidebar</span>

                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10" />
                    </svg>
                </button>
            @endif

            {{-- name and logo --}}
            <a href="{{ route('index') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-xl text-heading font-semibold whitespace-nowrap">AllStaff</span>
            </a>
        </div>

        {{-- User menu --}}
        @auth
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="button"
                    class="flex text-sm bg-neutral-primary rounded-full md:me-0 focus:ring-4 focus:ring-neutral-tertiary"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>

                    <img class="size-10 rounded-full" src="{{ $userProfile }}" alt="user photo">
                </button>

                <!-- Dropdown menu -->
                <div class="z-50 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44"
                    id="user-dropdown">
                    <div class="px-4 py-3 text-sm border-b border-default space-y-1">
                        @if($isAdmin)
                            <span class="block text-heading truncate">{{ $user->email }}</span>
                            <x-badge variant="alternative" class="mt-1">{{ $role->name }}</x-badge>
                        @else
                            <span class="block text-heading font-medium">{{ $employee->nama_lengkap }}</span>
                            <span class="block text-body truncate">{{ $employee->email }}</span>
                            <x-badge variant="alternative" class="mt-1">{{ $role->name }}</x-badge>
                        @endif
                    </div>
                    <ul class="p-2 text-sm text-body font-medium" aria-labelledby="user-menu-button">
                        <li>
                            <a href="#"
                                class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Dashboard</a>
                        </li>

                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button type="submit"
                                    class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded text-start">
                                    Sign out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <button data-collapse-toggle="navbar-user" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary"
                    aria-controls="navbar-user" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                    </svg>
                </button>
            </div>
        @endauth

        {{-- CTA button --}}
        @guest
            <div class="inline-flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <a href="{{ route('login') }}"
                    class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Login</a>


                <button data-collapse-toggle="navbar-cta" type="button"
                    class="inline-flex items-center p-2 w-9 h-9 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary"
                    aria-controls="navbar-cta" aria-expanded="false">

                    <span class="sr-only">Open main menu</span>

                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                    </svg>
                </button>
            </div>
        @endguest

        {{-- navbar link --}}
        @if (!$isDashboard)
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-cta">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-neutral-primary">
                    <li>
                        <a href="{{ route('index') }}"
                            class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.index') }}"
                            class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Dashboard</a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</nav>
