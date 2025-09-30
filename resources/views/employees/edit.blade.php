@extends('master')
@section('title', 'Edit Data Pegawai')

@section('content')
    <hgroup style="padding-top: 2rem">
        <h1>Edit Data Pegawai</h1>
        <p>TEKIK INFORMATIKA - PENS 28</p>
    </hgroup>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" style="margin-top: 2rem">
        @csrf
        @method('PUT')

        <fieldset>
            <label for="nama_lengkap">
                Nama Lengkap
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ $employee->nama_lengkap }}">
            </label>

            <div class="grid">
                <label for="email">
                    Email
                    <input type="email" id="email" name="email" value="{{ $employee->email }}">
                </label>

                <label for="nomor_telepon">
                    Nomor Telepon
                    <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ $employee->nomor_telepon }}">
                </label>

                <label for="tanggal_lahir">
                    Tanggal Lahir
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ $employee->tanggal_lahir }}">
                </label>
            </div>

            <label for="alamat">
                Alamat
                <textarea id="alamat" name="alamat">{{ $employee->alamat }}</textarea>
            </label>

            <div class="grid">
                <label for="tanggal_masuk">
                    Tanggal Masuk
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ $employee->tanggal_masuk }}">
                </label>

                <label for="status">
                    Status
                    <select id="status" name="status">
                        <option value="aktif" {{ old('status', $employee->status) == 'aktif' ? 'selected' : '' }}>
                            Aktif</option>
                        <option value="nonaktif" {{ old('status', $employee->status) == 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                </label>
            </div>
        </fieldset>

        <button type="submit">Simpan</button>
    </form>
@endsection
