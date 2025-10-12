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

                    <td style="display: flex; gap: 0.5rem">
                        <a role="button" href="{{ route('departments.show', $department->id) }}"
                            style="padding: 4px; width: fit-content; height: fit-content">Detail</a>
                        <a role="button" href="{{ route('departments.edit', $department->id) }}"
                            style="padding: 4px; width: fit-content; height: fit-content">Edit</a>

                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" role="link" style="padding: 4px; width: fit-content; height: fit-content"
                                onclick="return confirm('Yakin ingin menghapus?')" style="padding: 4px">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
