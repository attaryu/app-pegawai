@extends('layouts.dashboard')
@section('title', 'Leave Management')

@section('content')
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <x-text as="h1" variant="h2">Leave Management</x-text>
            <x-button href="{{ route('dashboard.employee.leave.create') }}">
                <i class="fa-solid fa-plus"></i>
                Request Leave
            </x-button>
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

        {{-- Leave Balance Overview --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Annual Leave --}}
            <x-card class="hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <x-text as="small" class="text-body-secondary">Annual Leave</x-text>
                        <x-text as="h2" class="mt-2 text-brand-primary">{{ $leaveBalance->annual_leave_balance }}</x-text>
                        <x-text as="small" class="text-body-secondary">days remaining</x-text>
                    </div>
                    <div class="text-4xl text-success">
                        <i class="fa-solid fa-umbrella-beach"></i>
                    </div>
                </div>
            </x-card>

            {{-- Sick Leave --}}
            <x-card class="hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <x-text as="small" class="text-body-secondary">Sick Leave</x-text>
                        <x-text as="h2" class="mt-2 text-danger">{{ $leaveBalance->sick_leave_balance }}</x-text>
                        <x-text as="small" class="text-body-secondary">days remaining</x-text>
                    </div>
                    <div class="text-4xl text-danger">
                        <i class="fa-solid fa-briefcase-medical"></i>
                    </div>
                </div>
            </x-card>

            {{-- Personal Leave --}}
            <x-card class="hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <x-text as="small" class="text-body-secondary">Personal Leave</x-text>
                        <x-text as="h2" class="mt-2 text-warning">{{ $leaveBalance->personal_leave_balance }}</x-text>
                        <x-text as="small" class="text-body-secondary">days remaining</x-text>
                    </div>
                    <div class="text-4xl text-warning">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                </div>
            </x-card>

            {{-- Total Days Used --}}
            <x-card class="hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <x-text as="small" class="text-body-secondary">Total Used</x-text>
                        <x-text as="h2" class="mt-2">{{ $totalDaysUsed }}</x-text>
                        <x-text as="small" class="text-body-secondary">days this year</x-text>
                    </div>
                    <div class="text-4xl text-body">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                </div>
            </x-card>
        </div>

        {{-- Recent Leave Requests --}}
        <x-card>
            <x-text as="h3" variant="h4" class="mb-4">Recent Leave Requests</x-text>

            @if($leaveRequests->isEmpty())
                <div class="text-center py-8">
                    <i class="fa-solid fa-inbox text-body text-4xl mb-2"></i>

                    <x-text as="p">No leave requests yet</x-text>
                    
                    <x-button href="{{ route('dashboard.employee.leave.create') }}" class="mt-4">
                        Make Your First Request
                    </x-button>
                </div>
            @else
                <x-table.table>
                    <x-table.head>
                        <x-table.heading>Type</x-table.heading>
                        <x-table.heading>Start Date</x-table.heading>
                        <x-table.heading>End Date</x-table.heading>
                        <x-table.heading>Days</x-table.heading>
                        <x-table.heading>Reason</x-table.heading>
                        <x-table.heading>Status</x-table.heading>
                        <x-table.heading>Requested At</x-table.heading>
                    </x-table.head>
                    <x-table.body>
                        @foreach($leaveRequests as $request)
                            <x-table.row>
                                <x-table.cell>
                                    @php
                                        $typeIcons = [
                                            'annual' => 'fa-umbrella-beach',
                                            'sick' => 'fa-briefcase-medical',
                                            'personal' => 'fa-user-clock'
                                        ];
                                        $typeColors = [
                                            'annual' => 'text-success',
                                            'sick' => 'text-danger',
                                            'personal' => 'text-warning'
                                        ];
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid {{ $typeIcons[$request->leave_type] }} {{ $typeColors[$request->leave_type] }}"></i>
                                        <span>{{ ucfirst($request->leave_type) }}</span>
                                    </div>
                                </x-table.cell>
                                <x-table.cell>{{ date('d M Y', strtotime($request->start_date)) }}</x-table.cell>
                                <x-table.cell>{{ date('d M Y', strtotime($request->end_date)) }}</x-table.cell>
                                <x-table.cell>{{ $request->days_requested }} day(s)</x-table.cell>
                                <x-table.cell>
                                    <div class="max-w-xs truncate" title="{{ $request->reason }}">
                                        {{ $request->reason }}
                                    </div>
                                </x-table.cell>
                                <x-table.cell>
                                    @php
                                        $statusVariants = [
                                            'pending' => 'warning',
                                            'approved' => 'success',
                                            'rejected' => 'danger'
                                        ];
                                    @endphp
                                    <x-badge :variant="$statusVariants[$request->status]">
                                        {{ ucfirst($request->status) }}
                                    </x-badge>
                                </x-table.cell>
                                <x-table.cell>{{ $request->created_at->diffForHumans() }}</x-table.cell>
                            </x-table.row>
                        @endforeach
                    </x-table.body>
                </x-table.table>
            @endif
        </x-card>
    </div>
@endsection
