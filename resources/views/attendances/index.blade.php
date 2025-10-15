@php
    $format = fn(string|null $date) => $date ? date_format(date_create($date), 'H:i') : '-';
@endphp

@extends('master')
@section('title', 'Daftar Kehadiran')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <hgroup style="padding-top: 2rem">
            <h1>Daftar Kehadiran</h1>
        </hgroup>

        <a href="{{ route('attendances.create') }}" role="button">Tambah</a>
    </div>

    <table style="margin-top: 2rem" class="striped overflow-auto">
        <thead>
            <tr>
                <th scope="col">Nama Karyawan</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Status</th>
                <th scope="col">Waktu Masuk</th>
                <th scope="col">Waktu Keluar</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <th scope="row">{{ $attendance->employee->nama_lengkap }}</th>
                    <td>{{ $attendance->tanggal }}</td>
                    <td>{{ $attendance->status }}</td>
                    <td>{{ $format($attendance->waktu_masuk) }}</td>
                    <td>{{ $format($attendance->waktu_keluar) }}</td>

                    <x-action route-name="attendances" :id="$attendance->id">
                        <x-action.update />
                        <x-action.delete />
                    </x-action>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection