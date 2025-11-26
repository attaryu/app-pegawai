@php
    $format = fn (float $value) => 'Rp ' . number_format($value, 0, ',', '.');
@endphp

@extends('layouts.dashboard')
@section('title', 'Daftar Gaji')

@section('content')
    <x-header title="Daftar Gaji" :paginator="$salaries" create-route-name="dashboard.admin.salaries.create" />

    <x-table.table class="mt-8">
        <x-table.head>
            <x-table.heading>Nama Karyawan</x-table.heading>
            <x-table.heading>Bulan</x-table.heading>
            <x-table.heading>Pokok</x-table.heading>
            <x-table.heading>Tunjangan</x-table.heading>
            <x-table.heading>Potongan</x-table.heading>
            <x-table.heading>Total</x-table.heading>
            <x-table.heading>Aksi</x-table.heading>
        </x-table.head>

        <x-table.body>
            @foreach($salaries as $salary)
                <x-table.row>
                    <x-table.cell header>{{ $salary->employee->nama_lengkap }}</x-table.cell>
                    <x-table.cell>{{ $salary->bulan }}</x-table.cell>
                    <x-table.cell>{{ $format($salary->gaji_pokok) }}</x-table.cell>
                    <x-table.cell>{{ $format($salary->gaji_tunjangan) }}</x-table.cell>
                    <x-table.cell>{{ $format($salary->potongan) }}</x-table.cell>
                    <x-table.cell>{{ $format($salary->total_gaji) }}</x-table.cell>
                    <x-table.cell>
                        <x-action route-name="dashboard.admin.salaries" :id="$salary->id">
                            <x-action.update />
                            <x-action.delete />
                        </x-action>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-table.body>
    </x-table.table>
@endsection
