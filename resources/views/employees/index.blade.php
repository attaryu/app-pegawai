@extends('master')
@section('title', 'Daftar Pegawai')

@section('content')
    <x-header title="Daftar Pegawai" :paginator="$employees" create-route-name="employees.create" />

    <div class="overflow-auto">
        <table style="margin-top: 2rem" class="striped">
            <thead>
                <tr>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Email</th>
                    <th scope="col">Nomor Telepon</th>
                    <th scope="col">Status</th>
                    <th scope="col">Departemen</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <th scope="row">{{ $employee->nama_lengkap }}</th>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->nomor_telepon }}</td>
                        <td>{{ $employee->status }}</td>
                        <td>{{ $employee->department->nama_departemen }}</td>
                        <td>{{ $employee->position->nama_jabatan }}</td>

                        <x-action route-name="employees" :id="$employee->id">
                            <x-action.detail />
                            <x-action.update />
                            <x-action.delete />
                        </x-action>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection