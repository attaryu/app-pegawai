@extends('master')
@section('title', 'Tambah Data Posisi')

@section('content')
    <x-header title="Tambah Data Posisi" />

    <form action="{{ route('positions.store') }}" method="POST" style="margin-top: 2rem">
        @csrf

        <fieldset class="grid">
            <label for="nama_jabatan">
                Nama Jabatan
                <input type="text" id="nama_jabatan" name="nama_jabatan">
            </label>

            <label for="gaji_pokok">
                Gaji Pokok
                <input type="number" id="gaji_pokok" name="gaji_pokok">
            </label>
        </fieldset>

        <button type="submit">Simpan</button>
    </form>
@endsection
