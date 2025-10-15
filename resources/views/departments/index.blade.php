@extends('master')
@section('title', 'Daftar Departemen')
@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 2rem">
        <h1>Daftar Departement</h1>
        <a href="{{ route('departments.create') }}" role="button">Tambah</a>
    </div>

    <table style="margin-top: 2rem" class="striped overflow-auto">
        <thead>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">Jumlah Karyawan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($departments as $department)
                <tr>
                    <th scope="row">{{ $department->nama_departemen }}</th>
                    <td>{{ $department->employees_count }}</td>

                    <x-action route-name="departments" :id="$department->id">
                        <x-action.detail />
                        <x-action.update />
                        <x-action.delete />
                    </x-action>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection