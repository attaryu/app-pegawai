@extends('master')
@section('title', 'Departemen')
@section('content')
    <x-header title="Detail Departemen" />

    <table style="margin-top: 2rem" class="striped overflow-auto">
        <tbody>
            <tr>
                <th>Nama Departemen</th>
                <td>{{ $department->nama_departemen }}</td>
            </tr>
            <tr>
                <th>Jumlah Karyawan</th>
                <td>{{ $department->employees->count() }}</td>
            </tr>
        </tbody>
    </table>

    <hgroup style="padding-top: 2rem">
        <h3>Daftar karyawan</h3>
    </hgroup>

    <table style="margin-top: 2rem" class="striped overflow-auto">
        <thead>
            <tr>
                <th scope="col">Nama Lengkap</th>
                <th scope="col">Email</th>
                <th scope="col">Nomor Telepon</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($department->employees as $employee)
                <tr>
                    <th scope="row">{{ $employee->nama_lengkap }}</th>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->nomor_telepon }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
