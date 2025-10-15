@extends('master')
@section('title', 'Tambah Data Kehadiran')

@section('content')
    <hgroup style="padding-top: 2rem">
        <h1>Tambah Data Kehadiran</h1>
    </hgroup>

    <form action="{{ route('attendances.store') }}" method="POST" style="margin-top: 2rem">
        @csrf

        <fieldset>
            <div class="grid">
                <label for="karyawan_id">
                    Karyawan
                    <select name="karyawan_id" id="karyawan_id">
                        <option value="" selected disabled>Pilih Karyawan</option>

                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </label>


                <label for="status">
                    Status
                    <select id="status" name="status">
                        <option value="Hadir" selected>Hadir</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Alpha">Alpha</option>
                    </select>
                </label>
            </div>

            <div class="grid">
                <label for="waktu_masuk">
                    Waktu Masuk
                    <input type="time" id="waktu_masuk" name="waktu_masuk">
                </label>

                <label for="waktu_keluar">
                    Waktu Keluar
                    <input type="time" id="waktu_keluar" name="waktu_keluar">
                </label>

                <label for="tanggal">
                    Tanggal
                    <input type="date" id="tanggal" name="tanggal" max="{{ date('Y-m-d') }}">
                </label>
            </div>
        </fieldset>

        <button type="submit">Simpan</button>
    </form>
@endsection
