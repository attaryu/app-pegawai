@extends('master')
@section('title', 'Tambah Data Pegawai')

@section('content')
    <hgroup style="padding-top: 2rem">
        <h1>Tambah Data Pegawai</h1>
        <p>TEKIK INFORMATIKA - PENS 28</p>
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
            </div>
        </fieldset>

        <button type="submit">Simpan</button>
    </form>
@endsection
