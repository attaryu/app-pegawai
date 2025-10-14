@extends('master')
@section('title', 'Daftar Posisi')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <hgroup style="padding-top: 2rem">
            <h1>Daftar Posisi</h1>
        </hgroup>

        <a href="{{ route('positions.create') }}" role="button">Tambah</a>
    </div>

    <table style="margin-top: 2rem" class="striped overflow-auto">
        <thead>
            <tr>
                <th scope="col">Nama Jabatan</th>
                <th scope="col">Gaji Pokok</th>
                <th scope="col">Jumlah Karyawan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($positions as $position)
                <tr>
                    <th scope="row">{{ $position->nama_jabatan }}</th>
                    <td>Rp {{ number_format($position->gaji_pokok, 0, ',', '.') }}</td>
                    <td>{{ $position->employees_count }}</td>

                    <td style="display: flex; align-items: center; gap: 0.5rem">
                        <a role="button" href="{{ route('positions.show', $position->id) }}" style="padding: 4px; width: fit-content; height: fit-content">Detail</a>
                        <a role="button" href="{{ route('positions.edit', $position->id) }}" style="padding: 4px; width: fit-content; height: fit-content">Edit</a>

                        <form action="{{ route('positions.destroy', $position->id) }}" method="POST" style="height: fit-content;">
                            @method('DELETE')
                            @csrf
                            <button type="submit" role="link" onclick="return confirm('Yakin ingin menghapus?')"
                                style="padding: 4px; width: fit-content; height: fit-content; margin: 0">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
