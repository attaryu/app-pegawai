@extends('layouts.dashboard')
@section('title', 'Leave Requests')

@section('content')
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <x-text as="h1" variant="h2">Leave Requests Management</x-text>
        </div>

        @if(session('success'))
            <x-alert variant="success" :dismissible="true">
                <span class="font-medium">Success!</span> {{ session('success') }}
            </x-alert>
        @endif

        @if(session('error'))
            <x-alert variant="danger" :dismissible="true">
                <span class="font-medium">Error!</span> {{ session('error') }}
            </x-alert>
        @endif

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-card class="hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <x-text as="small" class="text-body-secondary">Pending</x-text>
                        <x-text as="h2" class="mt-2 text-warning">{{ $statistics['pending'] }}</x-text>
                    </div>
                    <div class="text-4xl text-warning">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
            </x-card>

            <x-card class="hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <x-text as="small" class="text-body-secondary">Approved</x-text>
                        <x-text as="h2" class="mt-2 text-success">{{ $statistics['approved'] }}</x-text>
                    </div>
                    <div class="text-4xl text-success">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                </div>
            </x-card>

            <x-card class="hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <x-text as="small" class="text-body-secondary">Rejected</x-text>
                        <x-text as="h2" class="mt-2 text-danger">{{ $statistics['rejected'] }}</x-text>
                    </div>
                    <div class="text-4xl text-danger">
                        <i class="fa-solid fa-times-circle"></i>
                    </div>
                </div>
            </x-card>

            <x-card class="hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <x-text as="small" class="text-body-secondary">Cancelled</x-text>
                        <x-text as="h2" class="mt-2 text-neutral-secondary">{{ $statistics['cancelled'] }}</x-text>
                    </div>
                    <div class="text-4xl text-body">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                </div>
            </x-card>
        </div>

        <x-card>
            {{-- Filter Tabs --}}
            <div class="flex gap-2 mb-4 flex-wrap">
                <x-button href="{{ route('dashboard.admin.leave-requests.index', ['status' => 'all']) }}"
                    variant="{{ $status === 'all' ? 'primary' : 'secondary' }}" size="sm">
                    All Requests
                </x-button>

                <x-button href="{{ route('dashboard.admin.leave-requests.index', ['status' => 'pending']) }}"
                    variant="{{ $status === 'pending' ? 'primary' : 'secondary' }}" size="sm">
                    Pending
                </x-button>

                <x-button href="{{ route('dashboard.admin.leave-requests.index', ['status' => 'approved']) }}"
                    variant="{{ $status === 'approved' ? 'primary' : 'secondary' }}" size="sm">
                    Approved
                </x-button>

                <x-button href="{{ route('dashboard.admin.leave-requests.index', ['status' => 'rejected']) }}"
                    variant="{{ $status === 'rejected' ? 'primary' : 'secondary' }}" size="sm">
                    Rejected
                </x-button>

                <x-button href="{{ route('dashboard.admin.leave-requests.index', ['status' => 'cancelled']) }}"
                    variant="{{ $status === 'cancelled' ? 'primary' : 'secondary' }}" size="sm">
                    Cancelled
                </x-button>
            </div>

            {{-- Leave Requests Table --}}
            <div class="overflow-x-auto">
                <x-table>
                    <x-table.head>
                        <x-table.heading>Employee</x-table.heading>
                        <x-table.heading>Type</x-table.heading>
                        <x-table.heading>Date Range</x-table.heading>
                        <x-table.heading>Days</x-table.heading>
                        <x-table.heading>Reason</x-table.heading>
                        <x-table.heading>Status</x-table.heading>
                        <x-table.heading>Submitted</x-table.heading>
                        <x-table.heading class="text-center">Actions</x-table.heading>
                    </x-table.head>

                    <x-table.body>
                        @forelse($leaveRequests as $request)
                            <x-table.row>
                                <x-table.cell>
                                    <div>
                                        <x-text as="p" class="font-medium">{{ $request->employee->nama_lengkap }}</x-text>
                                        <x-text as="small" class="text-body-secondary">{{ $request->employee->email }}</x-text>
                                    </div>
                                </x-table.cell>

                                <x-table.cell>
                                    @php
                                        $typeIcons = [
                                            'annual' => ['icon' => 'fa-umbrella-beach', 'color' => 'text-success'],
                                            'sick' => ['icon' => 'fa-briefcase-medical', 'color' => 'text-danger'],
                                            'personal' => ['icon' => 'fa-user', 'color' => 'text-warning'],
                                        ];
                                        $typeConfig = $typeIcons[$request->leave_type] ?? ['icon' => 'fa-question', 'color' => 'text-neutral-secondary'];
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid {{ $typeConfig['icon'] }} {{ $typeConfig['color'] }}"></i>
                                        <span class="capitalize">{{ $request->leave_type }}</span>
                                    </div>
                                </x-table.cell>

                                <x-table.cell>
                                    <x-text as="small">
                                        {{ \Carbon\Carbon::parse($request->start_date)->format('d M Y') }}
                                        <span class="text-body-secondary">to</span>
                                        {{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}
                                    </x-text>
                                </x-table.cell>

                                <x-table.cell>
                                    {{ $request->days_requested }} {{ Str::plural('day', $request->days_requested) }}
                                </x-table.cell>

                                <x-table.cell>
                                    <x-text as="small" class="max-w-xs truncate block">{{ $request->reason }}</x-text>
                                </x-table.cell>

                                <x-table.cell>
                                    @php
                                        $statusVariants = [
                                            'pending' => 'warning',
                                            'approved' => 'success',
                                            'rejected' => 'danger',
                                            'cancelled' => 'alternative',
                                        ];
                                    @endphp
                                    <x-badge variant="{{ $statusVariants[$request->status] ?? 'secondary' }}">
                                        {{ ucfirst($request->status) }}
                                    </x-badge>
                                </x-table.cell>

                                <x-table.cell>
                                    <x-text as="small" class="text-body-secondary">
                                        {{ $request->created_at->diffForHumans() }}
                                    </x-text>
                                </x-table.cell>

                                <x-table.cell class="text-center">
                                    @if($request->status === 'pending')
                                        <div class="flex gap-2 justify-center">
                                            <x-button type="button" variant="success" size="sm" :isIcon="true"
                                                data-modal-target="approve-modal-{{ $request->id }}"
                                                data-modal-toggle="approve-modal-{{ $request->id }}">
                                                <i class="fa-solid fa-check"></i>
                                            </x-button>
                                            <x-button type="button" variant="danger" size="sm" :isIcon="true"
                                                data-modal-target="reject-modal-{{ $request->id }}"
                                                data-modal-toggle="reject-modal-{{ $request->id }}">
                                                <i class="fa-solid fa-times"></i>
                                            </x-button>
                                        </div>
                                    @else
                                        <x-text as="small" class="text-body-secondary">-</x-text>
                                    @endif
                                </x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell colspan="8" class="text-center">
                                    <x-text as="p" class="text-body-secondary py-4">No leave requests found</x-text>
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-table.body>
                </x-table>
            </div>

            {{-- Pagination --}}
            @if($leaveRequests->hasPages())
                <div class="mt-4">
                    {{ $leaveRequests->links() }}
                </div>
            @endif
        </x-card>
    </div>

    {{-- Modals for each request --}}
    @foreach($leaveRequests as $request)
        @if($request->status === 'pending')
            {{-- Approve Modal --}}
            <x-modal id="approve-modal-{{ $request->id }}" title="Approve Leave Request" icon="fa-check-circle"
                iconColor="text-success" size="md">
                <x-text as="p" class="text-body-secondary mb-4">
                    Are you sure you want to approve the leave request from
                    <span class="font-medium text-heading">{{ $request->employee->nama_lengkap }}</span>?
                </x-text>

                <div class="bg-neutral-primary-medium rounded-base p-4 text-left space-y-2 mb-4">
                    <div class="flex justify-between">
                        <x-text as="small" class="text-body-secondary">Leave Type:</x-text>
                        <x-text as="small" class="font-medium capitalize">{{ $request->leave_type }}</x-text>
                    </div>
                    <div class="flex justify-between">
                        <x-text as="small" class="text-body-secondary">Duration:</x-text>
                        <x-text as="small" class="font-medium">{{ $request->days_requested }}
                            {{ Str::plural('day', $request->days_requested) }}</x-text>
                    </div>
                    <div class="flex justify-between">
                        <x-text as="small" class="text-body-secondary">Date Range:</x-text>
                        <x-text as="small" class="font-medium">
                            {{ \Carbon\Carbon::parse($request->start_date)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}
                        </x-text>
                    </div>
                </div>

                <x-slot name="actions">
                    <x-button type="button" variant="secondary" data-modal-hide="approve-modal-{{ $request->id }}">
                        Cancel
                    </x-button>
                    <form action="{{ route('dashboard.admin.leave-requests.approve', $request->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <x-button type="submit" variant="success">
                            <i class="fa-solid fa-check"></i>
                            Approve Request
                        </x-button>
                    </form>
                </x-slot>
            </x-modal>

            {{-- Reject Modal --}}
            <x-modal id="reject-modal-{{ $request->id }}" title="Reject Leave Request" icon="fa-times-circle"
                iconColor="text-danger" size="md">
                <x-text as="p" class="text-body-secondary mb-4">
                    Are you sure you want to reject the leave request from
                    <span class="font-medium text-heading">{{ $request->employee->nama_lengkap }}</span>?
                </x-text>

                <div class="bg-neutral-primary-medium rounded-base p-4 text-left space-y-2 mb-4">
                    <div class="flex justify-between">
                        <x-text as="small" class="text-body-secondary">Leave Type:</x-text>
                        <x-text as="small" class="font-medium capitalize">{{ $request->leave_type }}</x-text>
                    </div>
                    <div class="flex justify-between">
                        <x-text as="small" class="text-body-secondary">Duration:</x-text>
                        <x-text as="small" class="font-medium">{{ $request->days_requested }}
                            {{ Str::plural('day', $request->days_requested) }}</x-text>
                    </div>
                    <div class="flex justify-between">
                        <x-text as="small" class="text-body-secondary">Date Range:</x-text>
                        <x-text as="small" class="font-medium">
                            {{ \Carbon\Carbon::parse($request->start_date)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}
                        </x-text>
                    </div>
                </div>

                <form id="reject-form-{{ $request->id }}" action="{{ route('dashboard.admin.leave-requests.reject', $request->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <x-input as="textarea" id="rejection_reason_{{ $request->id }}" name="rejection_reason"
                        label="Rejection Reason (Optional)" placeholder="Provide a reason for rejection..." rows="4" />
                </form>

                <x-slot name="actions">
                    <x-button type="button" variant="secondary" data-modal-hide="reject-modal-{{ $request->id }}">
                        Cancel
                    </x-button>

                    <x-button type="submit" variant="danger" form="reject-form-{{ $request->id }}">
                        <i class="fa-solid fa-times"></i>
                        Reject Request
                    </x-button>
                </x-slot>
            </x-modal>
        @endif
    @endforeach
@endsection
