@extends('layouts.dashboard')
@section('title', 'Daftar Posisi')

@section('content')
    <x-header title="Daftar Posisi" :paginator="$positions" create-route-name="dashboard.admin.positions.create" />

    <x-table.table class="mt-8">
        <x-table.head>
            <x-table.heading>Nama Jabatan</x-table.heading>
            <x-table.heading>Gaji Pokok</x-table.heading>
            <x-table.heading>Jumlah Karyawan</x-table.heading>
            <x-table.heading>Aksi</x-table.heading>
        </x-table.head>

        <x-table.body>
            @foreach($positions as $position)
                <x-table.row>
                    <x-table.cell header>{{ $position->nama_jabatan }}</x-table.cell>
                    <x-table.cell>Rp {{ number_format($position->gaji_pokok, 0, ',', '.') }}</x-table.cell>
                    <x-table.cell>{{ $position->employees_count }}</x-table.cell>
                    <x-table.cell>
                        <x-action route-name="dashboard.admin.positions" :id="$position->id">
                            <x-action.detail />
                            <x-action.update />
                            <x-action.delete />
                        </x-action>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-table.body>
    </x-table.table>
@endsection
