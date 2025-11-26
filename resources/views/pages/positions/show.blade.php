@extends('master')
@section('title', 'Detail Posisi')
@section('content')
    <x-header title="Detail Posisi" />

    <table style="margin-top: 2rem" class="striped overflow-auto">
        <tbody>
            <tr>
                <th scope="row">Nama Jabatan</th>
                <td>{{ $position->nama_jabatan }}</td>
            </tr>

            <tr>
                <th scope="row">Gaji Pokok</th>
                <td>{{ $position->gaji_pokok }}</td>
            </tr>
        </tbody>
    </table>

    <hgroup style="padding-top: 2rem">
        <h3>Daftar Karyawan yang Memiliki Posisi Ini</h3>
    </hgroup>

    <table style="margin-top: 2rem" class="striped overflow-auto">
        <thead>
            <tr>
                <th scope="col">Nama Lengkap</th>
                <th scope="col">Email</th>
                <th scope="col">Nomor Telepon</th>
                <th scope="col">Departemen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($position->employees as $employee)
                <tr>
                    <th scope="row">{{ $employee->nama_lengkap }}</th>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->nomor_telepon }}</td>
                    <td>{{ $employee->department->nama_departemen }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
