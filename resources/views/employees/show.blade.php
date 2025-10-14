@extends('master')
@section('title', 'Detail Pegawai')
@section('content')
    <hgroup style="padding-top: 2rem">
        <h1>Pegawai</h1>
    </hgroup>

    <table style="margin-top: 2rem" class="striped overflow-auto">
        <tbody>
            <tr>
                <th scope="row">Nama Lengkap</th>
                <td>{{ $employee->nama_lengkap }}</td>
            </tr>

            <tr>
                <th scope="row">Email</th>
                <td>{{ $employee->email }}</td>
            </tr>

            <tr>
                <th scope="row">Nomor Telepon</th>
                <td>{{ $employee->nomor_telepon }}</td>
            </tr>

            <tr>
                <th scope="row">Tanggal Lahir</th>
                <td>{{ $employee->tanggal_lahir }}</td>
            </tr>

            <tr>
                <th scope="row">Alamat</th>
                <td>{{ $employee->alamat }}</td>
            </tr>

            <tr>
                <th scope="row">Tanggal Masuk</th>
                <td>{{ $employee->tanggal_masuk }}</td>
            </tr>

            <tr>
                <th scope="row">Status</th>
                <td>{{ $employee->status }}</td>
            </tr>
        </tbody>
    </table>
@endsection
