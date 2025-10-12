@extends('master')
@section('title', 'Tambah Data Departemen')

@section('content')
    <hgroup style="padding-top: 2rem">
        <h1>Tambah Data Departemen</h1>
    </hgroup>

    <form action="{{ route('departments.store') }}" method="POST" style="margin-top: 2rem">
        @csrf

        <fieldset>
            <label for="nama_departemen">
                Nama Departemen
                <input type="text" id="nama_departemen" name="nama_departemen">
            </label>
        </fieldset>

        <button type="submit">Simpan</button>
    </form>
@endsection
