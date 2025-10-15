@extends('master')
@section('title', 'Daftar Departemen')
@section('content')
    <x-header title="Daftar Departemen" :paginator="$departments" create-route-name="departments.create" />

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