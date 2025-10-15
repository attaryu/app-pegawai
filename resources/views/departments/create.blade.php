@extends('master')
@section('title', 'Tambah Data Departemen')

@section('content')
    <x-header title="Tambah Data Departemen" />

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
