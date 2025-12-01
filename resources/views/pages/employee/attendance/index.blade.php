@php
    $format = fn(string|null $date) => $date ? date_format(date_create($date), 'H:i') : '-';
@endphp

@extends('layouts.dashboard')
@section('title', 'Attendances History')

@section('content')
    <div class="space-y-6">
        <x-header title="Attendances History" :paginator="$attendances" />

        <x-table.table>
            <x-table.head>
                <x-table.heading>Tanggal</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading>Waktu Masuk</x-table.heading>
                <x-table.heading>Waktu Keluar</x-table.heading>
            </x-table.head>

            <x-table.body>
                @foreach($attendances as $attendance)
                    <x-table.row>
                        <x-table.cell>{{ $attendance->tanggal }}</x-table.cell>
                        <x-table.cell>{{ $attendance->status }}</x-table.cell>
                        <x-table.cell>{{ $format($attendance->waktu_masuk) }}</x-table.cell>
                        <x-table.cell>{{ $format($attendance->waktu_keluar) }}</x-table.cell>
                    </x-table.row>
                @endforeach
            </x-table.body>
        </x-table.table>
    </div>
@endsection
