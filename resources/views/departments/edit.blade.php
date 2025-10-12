@extends('master')
@section('title', 'Edit Data Departemen')

@section('content')
    <hgroup style="padding-top: 2rem">
        <h1>Edit Data Departemen</h1>
    </hgroup>

    <form action="{{ route('departments.update', $department->id) }}" method="POST" style="margin-top: 2rem">
        @csrf
        @method('PUT')

        <fieldset>
            <label for="nama_departemen">
                Nama Departemen
                <input type="text" id="nama_departemen" name="nama_departemen" value="{{ $department->nama_departemen }}">
            </label>
        </fieldset>

        <button type="submit">Simpan</button>
    </form>
@endsection
