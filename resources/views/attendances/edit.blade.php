@php
    $format = fn (string $date) => date_format(date_create($date), 'H:i');
@endphp

@extends('master')
@section('title', 'Edit Data Kehadiran')

@section('content')
    <hgroup style="padding-top: 2rem">
        <h1>Edit Data Kehadiran</h1>
    </hgroup>

    <form action="{{ route('attendances.update', $attendance->id) }}" method="POST" style="margin-top: 2rem">
        @csrf
        @method('PUT')

        <fieldset>
            <div class="grid">
                <label for="karyawan_id">
                    Karyawan
                    <select name="karyawan_id" id="karyawan_id">
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('karyawan_id', $attendance->karyawan_id) == $employee->id ? 'selected' : '' }}>{{ $employee->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </label>


                <label for="status">
                    Status
                    <select id="status" name="status">
                        @foreach (['Hadir', 'Izin', 'Sakit', 'Alpha'] as $status)
                            @php
                                $lowercase = strtolower($status);
                            @endphp

                            <option value="{{ $lowercase }}" {{ old('status', $attendance->status) == $lowercase ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="grid">
                <label for="waktu_masuk">
                    Waktu Masuk
                    <input type="time" id="waktu_masuk" name="waktu_masuk" value="{{ $format($attendance->waktu_masuk) }}">
                </label>

                <label for="waktu_keluar">
                    Waktu Keluar
                    <input type="time" id="waktu_keluar" name="waktu_keluar" value="{{ $format($attendance->waktu_keluar) }}">
                </label>

                <label for="tanggal">
                    Tanggal
                    <input type="date" id="tanggal" name="tanggal" value="{{ $attendance->tanggal }}" max="{{ date('Y-m-d') }}">
                </label>
            </div>
        </fieldset>

        <button type="submit">Simpan</button>
    </form>
@endsection
