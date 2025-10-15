@extends('master')
@section('title', 'Daftar Posisi')

@section('content')
    <x-header title="Daftar Posisi" :paginator="$positions" create-route-name="positions.create" />

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

                    <x-action route-name="positions" :id="$position->id">
                        <x-action.detail />
                        <x-action.update />
                        <x-action.delete />
                    </x-action>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection