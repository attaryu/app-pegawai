@php
    $format = fn(float $value) => 'Rp ' . number_format($value, 0, ',', '.');
@endphp

@extends('layouts.dashboard')
@section('title', 'Salary History')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex gap-4 items-center">
            <x-text as="h1" variant="h2">Salary History</x-text>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Total Earned --}}
            <x-card>
                <div class="flex items-center justify-between">
                    <div>
                        <x-text as="p" class="text-sm text-gray-500 mb-1">Total Earned</x-text>
                        <x-text as="h3" variant="h4" class="text-brand">{{ $format($totalEarned) }}</x-text>
                    </div>
                    <div class="p-3 bg-brand-soft rounded-lg">
                        <i class="fa-solid fa-wallet text-2xl text-brand"></i>
                    </div>
                </div>
            </x-card>

            {{-- Current Month Salary --}}
            <x-card>
                <div class="flex items-center justify-between">
                    <div>
                        <x-text as="p" class="text-sm text-gray-500 mb-1">{{ $currentMonth }}</x-text>
                        <x-text as="h3" variant="h4" class="text-success">
                            {{ $currentMonthSalary ? $format($currentMonthSalary->total_gaji) : 'Not yet paid' }}
                        </x-text>
                    </div>
                    <div class="p-3 bg-success-soft rounded-lg">
                        <i class="fa-solid fa-money-bill-wave text-2xl text-success"></i>
                    </div>
                </div>
            </x-card>

            {{-- Total Payments --}}
            <x-card>
                <div class="flex items-center justify-between">
                    <div>
                        <x-text as="p" class="text-sm text-gray-500 mb-1">Total Payments</x-text>
                        <x-text as="h3" variant="h4" class="text-heading">{{ $salaries->total() }} times</x-text>
                    </div>
                    <div class="p-3 bg-neutral-secondary-medium rounded-lg">
                        <i class="fa-solid fa-receipt text-2xl text-heading"></i>
                    </div>
                </div>
            </x-card>
        </div>

        {{-- Salary Table --}}
        <x-card>
            <div class="mb-6">
                <x-text as="h3" variant="h4">Payment History</x-text>
                <x-text as="p" class="text-sm text-gray-500 mt-1">View all your salary payment records</x-text>
            </div>

            @if($salaries->count() > 0)
                <x-table.table>
                    <x-table.head>
                        <x-table.heading>Month</x-table.heading>
                        <x-table.heading>Base Salary</x-table.heading>
                        <x-table.heading>Allowance</x-table.heading>
                        <x-table.heading>Deduction</x-table.heading>
                        <x-table.heading>Total</x-table.heading>
                        <x-table.heading>Action</x-table.heading>
                    </x-table.head>

                    <x-table.body>
                        @foreach($salaries as $salary)
                            <x-table.row>
                                <x-table.cell header>
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-calendar text-brand"></i>
                                        {{ $salary->bulan }}
                                    </div>
                                </x-table.cell>
                                <x-table.cell>{{ $format($salary->gaji_pokok) }}</x-table.cell>
                                <x-table.cell>
                                    <span class="text-success">+ {{ $format($salary->gaji_tunjangan) }}</span>
                                </x-table.cell>
                                <x-table.cell>
                                    <span class="text-danger">- {{ $format($salary->potongan) }}</span>
                                </x-table.cell>
                                <x-table.cell>
                                    <x-text as="span" class="font-semibold text-brand">
                                        {{ $format($salary->total_gaji) }}
                                    </x-text>
                                </x-table.cell>
                                <x-table.cell>
                                    <x-button
                                        as="a"
                                        href="{{ route('dashboard.employee.salaries.print', $salary->id) }}"
                                        variant="secondary"
                                        size="sm"
                                        target="_blank"
                                    >
                                        <i class="fa-solid fa-print"></i>
                                        Print Slip
                                    </x-button>
                                </x-table.cell>
                            </x-table.row>
                        @endforeach
                    </x-table.body>
                </x-table.table>

                {{-- Pagination --}}
                @if($salaries->hasPages())
                    <div class="mt-6 flex justify-end">
                        <x-pagination :paginator="$salaries" />
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <i class="fa-solid fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <x-text as="p" class="text-gray-500">No salary records found</x-text>
                </div>
            @endif
        </x-card>

        {{-- Salary Breakdown Info --}}
        @if($currentMonthSalary)
            <x-card>
                <x-text as="h3" variant="h5" class="mb-4">Current Month Breakdown ({{ $currentMonth }})</x-text>

                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <x-text as="span" class="text-gray-600">Base Salary</x-text>
                        <x-text as="span" class="font-medium">{{ $format($currentMonthSalary->gaji_pokok) }}</x-text>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <x-text as="span" class="text-gray-600">Allowance</x-text>
                        <x-text as="span" class="font-medium text-success">+
                            {{ $format($currentMonthSalary->gaji_tunjangan) }}</x-text>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <x-text as="span" class="text-gray-600">Deduction</x-text>
                        <x-text as="span" class="font-medium text-danger">-
                            {{ $format($currentMonthSalary->potongan) }}</x-text>
                    </div>

                    <div class="flex justify-between items-center py-3 bg-brand-softer rounded-lg px-4">
                        <x-text as="span" variant="h6">Total Salary</x-text>
                        <x-text as="span" variant="h5"
                            class="text-brand">{{ $format($currentMonthSalary->total_gaji) }}</x-text>
                    </div>
                </div>
            </x-card>
        @endif
    </div>
@endsection
