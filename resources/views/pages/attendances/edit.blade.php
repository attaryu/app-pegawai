@php
    $format = fn (string $date) => date_format(date_create($date), 'H:i');
@endphp

@extends('layouts.dashboard')
@section('title', 'Edit Data Kehadiran')

@section('content')
    <x-card>
        <x-header title="Edit Data Kehadiran" />

        <form action="{{ route('dashboard.admin.attendances.update', $attendance->id) }}" method="POST" class="mt-8 space-y-6">
            @csrf
            @method('PUT')

            <fieldset class="space-y-4">
                <div class="flex gap-4 w-full">
                    <x-select id="karyawan_id" name="karyawan_id" error="{{ $errors->first('karyawan_id') }}"
                        label="Karyawan" class="w-full">
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('karyawan_id', $attendance->karyawan_id) == $employee->id ? 'selected' : '' }}>{{ $employee->nama_lengkap }}</option>
                        @endforeach
                    </x-select>

                    <x-select id="status" name="status" error="{{ $errors->first('status') }}"
                        label="Status" :options="['Hadir' => 'Hadir', 'Izin' => 'Izin', 'Sakit' => 'Sakit', 'Alpha' => 'Alpha']"
                        value="{{ old('status', $attendance->status) }}" class="w-full" />
                </div>

                <div class="flex gap-4 w-full">
                    <x-input id="waktu_masuk" name="waktu_masuk" error="{{ $errors->first('waktu_masuk') }}"
                        label="Waktu Masuk" type="time" value="{{ old('waktu_masuk', $format($attendance->waktu_masuk)) }}" class="w-full" />

                    <x-input id="waktu_keluar" name="waktu_keluar" error="{{ $errors->first('waktu_keluar') }}"
                        label="Waktu Keluar" type="time" value="{{ old('waktu_keluar', $format($attendance->waktu_keluar)) }}" class="w-full" />

                    <x-input id="tanggal" name="tanggal" error="{{ $errors->first('tanggal') }}"
                        label="Tanggal" type="date" value="{{ old('tanggal', $attendance->tanggal) }}" class="w-full" />
                </div>
            </fieldset>

            <div class="flex gap-4">
                <x-button type="reset" variant="secondary" class="ml-auto">Reset</x-button>
                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </x-card>
@endsection
