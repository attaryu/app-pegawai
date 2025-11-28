@php
    $format = fn(string|null $date) => $date ? date_format(date_create($date), 'H:i') : '-';
@endphp

@extends('layouts.dashboard')
@section('title', 'Attendances')

@section('content')
    <x-header title="Attendances" :paginator="$attendances"/>

    <x-table.table class="mt-8">
        <x-table.head>
            <x-table.heading>Nama Karyawan</x-table.heading>
            <x-table.heading>Tanggal</x-table.heading>
            <x-table.heading>Status</x-table.heading>
            <x-table.heading>Waktu Masuk</x-table.heading>
            <x-table.heading>Waktu Keluar</x-table.heading>
            <x-table.heading>Aksi</x-table.heading>
        </x-table.head>

        <x-table.body>
            @foreach($attendances as $attendance)
                <x-table.row>
                    <x-table.cell header>{{ $attendance->employee->nama_lengkap }}</x-table.cell>
                    <x-table.cell>{{ $attendance->tanggal }}</x-table.cell>
                    <x-table.cell>{{ $attendance->status }}</x-table.cell>
                    <x-table.cell>{{ $format($attendance->waktu_masuk) }}</x-table.cell>
                    <x-table.cell>{{ $format($attendance->waktu_keluar) }}</x-table.cell>
                    <x-table.cell>
                        <x-action route-name="dashboard.admin.attendances" :id="$attendance->id">
                            <x-action.update />
                            <x-action.delete />
                        </x-action>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-table.body>
    </x-table.table>
@endsection
