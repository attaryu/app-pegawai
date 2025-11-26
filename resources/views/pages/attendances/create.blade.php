@extends('layouts.dashboard')
@section('title', 'Tambah Data Kehadiran')

@section('content')
    <x-card>
        <x-header title="Tambah Data Kehadiran" />

        <form action="{{ route('dashboard.admin.attendances.store') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <fieldset class="space-y-4">
                <div class="flex gap-4 w-full">
                    <x-select id="karyawan_id" name="karyawan_id" error="{{ $errors->first('karyawan_id') }}"
                        label="Karyawan" class="w-full">
                        <option value="" selected disabled>Pilih Karyawan</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->nama_lengkap }}</option>
                        @endforeach
                    </x-select>

                    <x-select id="status" name="status" error="{{ $errors->first('status') }}"
                        label="Status" :options="['Hadir' => 'Hadir', 'Izin' => 'Izin', 'Sakit' => 'Sakit', 'Alpha' => 'Alpha']"
                        class="w-full" />
                </div>

                <div class="flex gap-4 w-full">
                    <x-input id="waktu_masuk" name="waktu_masuk" error="{{ $errors->first('waktu_masuk') }}"
                        label="Waktu Masuk" type="time" class="w-full" />

                    <x-input id="waktu_keluar" name="waktu_keluar" error="{{ $errors->first('waktu_keluar') }}"
                        label="Waktu Keluar" type="time" class="w-full" />

                    <x-input id="tanggal" name="tanggal" error="{{ $errors->first('tanggal') }}"
                        label="Tanggal" type="date" class="w-full" />
                </div>
            </fieldset>

            <div class="flex gap-4">
                <x-button type="reset" variant="secondary" class="ml-auto">Reset</x-button>
                <x-button type="submit">Simpan</x-button>
            </div>
        </form>
    </x-card>
@endsection
