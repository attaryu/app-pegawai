@extends('master')
@section('title', 'Daftar Pegawai')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <hgroup style="padding-top: 2rem">
            <h1>Daftar Pegawai</h1>
            <p>TEKIK INFORMATIKA - PENS 28</p>
        </hgroup>

        <a href="{{ route('employees.create') }}" role="button">Tambah</a>
    </div>

    <table style="margin-top: 2rem" class="striped overflow-auto">
        <thead>
            <tr>
                <th scope="col">Nama Lengkap</th>
                <th scope="col">Email</th>
                <th scope="col">Nomor Telepon</th>
                <th scope="col">Tanggal Lahir</th>
                <th scope="col">Alamat</th>
                <th scope="col">Tanggal Masuk</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <th scope="row">{{ $employee->nama_lengkap }}</th>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->nomor_telepon }}</td>
                    <td>{{ $employee->tanggal_lahir }}</td>
                    <td>{{ $employee->alamat }}</td>
                    <td>{{ $employee->tanggal_masuk }}</td>
                    <td>{{ $employee->status }}</td>

                    <td style="display: flex; flex-direction: column; gap: 0.5rem">
                        <a role="button" href="{{ route('employees.show', $employee->id) }}" style="padding: 4px">Detail</a>
                        <a role="button" href="{{ route('employees.edit', $employee->id) }}" style="padding: 4px">Edit</a>

                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" role="link" onclick="return confirm('Yakin ingin menghapus?')"
                                style="padding: 4px">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
