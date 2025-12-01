@php
    $user = auth()->user();
    $role = $user->role->name;
@endphp

<aside id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default">
        <a href="{{ route('dashboard.index') }}" class="flex items-center ps-2.5 mb-5">
            <span class="self-center text-lg text-heading font-semibold whitespace-nowrap">AllStaff</span>
        </a>

        <ul class="flex flex-col gap-2 font-medium mt-10">
            <x-sidebar.item href="{{ route('dashboard.index') }}" route="dashboard.index"
                icon="fa-solid fa-table-columns">
                Dashboard
            </x-sidebar.item>
        </ul>


        @can('is-admin')
            <ul class="flex flex-col gap-2 font-medium mt-5">
                <x-text as="small" class="mb-1">Employee</x-text>

                <x-sidebar.item href="{{ route('dashboard.admin.employees.index') }}" route="dashboard.admin.employees.*"
                    icon="fa-solid fa-address-card">
                    Employees
                </x-sidebar.item>

                <x-sidebar.item href="{{ route('dashboard.admin.leave-requests.index') }}"
                    route="dashboard.admin.leave-requests.*" icon="fa-solid fa-umbrella-beach   ">
                    Leave Requests
                </x-sidebar.item>
            </ul>

            <ul class="flex flex-col gap-2 font-medium mt-5">
                <x-text as="small" class="mb-1">Other</x-text>

                <x-sidebar.item href="{{ route('dashboard.admin.departments.index') }}"
                    route="dashboard.admin.departments.*" icon="fa-solid fa-building">
                    Departments
                </x-sidebar.item>

                <x-sidebar.item href="{{ route('dashboard.admin.positions.index') }}" route="dashboard.admin.positions.*"
                    icon="fa-solid fa-briefcase">
                    Positions
                </x-sidebar.item>

                {{-- <x-sidebar.item href="{{ route('dashboard.admin.salaries.index') }}" route="dashboard.admin.salaries.*"
                    icon="fa-solid fa-sack-dollar">
                    Salaries
                </x-sidebar.item>

                <x-sidebar.item href="{{ route('dashboard.admin.attendances.index') }}"
                    route="dashboard.admin.attendances.*" icon="fa-solid fa-clipboard-user">
                    Attendances
                </x-sidebar.item> --}}
            </ul>
        @endcan

        @can('is-employee')
            <ul class="flex flex-col gap-2 font-medium mt-5">
                <x-text as="small" class="mb-1">Management</x-text>

                <x-sidebar.item href="{{ route('dashboard.employee.leave.index') }}" route="dashboard.employee.leave.*"
                    icon="fa-solid fa-umbrella-beach">
                    Leave
                </x-sidebar.item>
            </ul>

            <ul class="flex flex-col gap-2 font-medium mt-5">
                <x-text as="small" class="mb-1">Information</x-text>

                <x-sidebar.item href="{{ route('dashboard.employee.statistic') }}" route="dashboard.employee.statistic.*"
                    icon="fa-solid fa-chart-line">
                    Statistic
                </x-sidebar.item>

                <x-sidebar.item href="{{ route('dashboard.employee.attendances.history') }}"
                    route="dashboard.employee.attendances.history" icon="fa-solid fa-clipboard-user">
                    Attendance
                </x-sidebar.item>
            </ul>
        @endcan
    </div>
</aside>
