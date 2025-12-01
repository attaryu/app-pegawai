@extends('layouts.dashboard')
@section('title', 'Daftar Departemen')
@section('content')
    <x-header title="Daftar Departemen" :paginator="$departments" create-route-name="dashboard.admin.departments.create" />

    <x-table.table class="mt-8">
        <x-table.head>
            <x-table.heading>Nama</x-table.heading>
            <x-table.heading>Jumlah Karyawan</x-table.heading>
            <x-table.heading>Aksi</x-table.heading>
        </x-table.head>

        <x-table.body>
            @foreach($departments as $department)
                <x-table.row>
                    <x-table.cell header>{{ $department->nama_departemen }}</x-table.cell>
                    <x-table.cell>{{ $department->employees_count }}</x-table.cell>
                    <x-table.cell>
                        <x-action route-name="dashboard.admin.departments" :id="$department->id">
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
