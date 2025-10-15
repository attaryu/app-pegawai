@extends('master')
@section('title', 'Edit Data Posisi')

@section('content')
    <x-header title="Edit Data Posisi" />

    <form action="{{ route('positions.update', $position->id) }}" method="POST" style="margin-top: 2rem">
        @csrf
        @method('PUT')

        <fieldset class="grid">
            <label for="nama_jabatan">
                Nama Jabatan
                <input type="text" id="nama_jabatan" name="nama_jabatan" value="{{ $position->nama_jabatan }}">
            </label>

            <label for="gaji_pokok">
                Gaji Pokok
                <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ $position->gaji_pokok }}">
            </label>
        </fieldset>

        <button type="submit">Simpan</button>
    </form>
@endsection
