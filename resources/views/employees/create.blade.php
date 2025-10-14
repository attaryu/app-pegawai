@extends('master')
@section('title', 'Tambah Data Pegawai')

@section('content')
    <hgroup style="padding-top: 2rem">
        <h1>Tambah Data Pegawai</h1>
    </hgroup>

    <form action="{{ route('employees.store') }}" method="POST" style="margin-top: 2rem">
        @csrf

        <fieldset>
            <label for="nama_lengkap">
                Nama Lengkap
                <input type="text" id="nama_lengkap" name="nama_lengkap">
            </label>

            <div class="grid">
                <label for="email">
                    Email
                    <input type="email" id="email" name="email">
                </label>

                <label for="nomor_telepon">
                    Nomor Telepon
                    <input type="text" id="nomor_telepon" name="nomor_telepon">
                </label>

                <label for="tanggal_lahir">
                    Tanggal Lahir
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir">
                </label>
            </div>

            <label for="alamat">
                Alamat
                <textarea id="alamat" name="alamat"></textarea>
            </label>

            <div class="grid">
                <label for="tanggal_masuk">
                    Tanggal Masuk
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk">
                </label>

                <label for="status">
                    Status
                    <select id="status" name="status">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </label>

                <label for="departemen_id">
                    Departemen
                    <select id="departemen_id" name="departemen_id">
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->nama_departemen }}</option>
                        @endforeach
                    </select>
                </label>

                <label for="jabatan_id">
                    Jabatan
                    <select id="jabatan_id" name="jabatan_id">
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->nama_jabatan }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </fieldset>

        <button type="submit">Simpan</button>
    </form>
@endsection
