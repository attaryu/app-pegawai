@extends('layouts.dashboard')
@section('title', 'Employee List')

@section('content')
    <x-header title="Employee List" :paginator="$employees" create-route-name="dashboard.admin.employees.create" />

    <x-table class="mt-8">
        <x-table.head>
            <x-table.heading>Nama Lengkap</x-table.heading>
            <x-table.heading>Email</x-table.heading>
            <x-table.heading>Nomor Telepon</x-table.heading>
            <x-table.heading>Status</x-table.heading>
            <x-table.heading>Departemen</x-table.heading>
            <x-table.heading>Jabatan</x-table.heading>
            <x-table.heading>Aksi</x-table.heading>
        </x-table.head>

        <x-table.body>
            @foreach($employees as $employee)
                <x-table.row>
                    <x-table.cell header>{{ $employee->nama_lengkap }}</x-table.cell>
                    <x-table.cell>{{ $employee->email }}</x-table.cell>
                    <x-table.cell>{{ $employee->nomor_telepon }}</x-table.cell>
                    <x-table.cell>{{ $employee->status }}</x-table.cell>
                    <x-table.cell>{{ $employee->department->nama_departemen }}</x-table.cell>
                    <x-table.cell>{{ $employee->position->nama_jabatan }}</x-table.cell>
                    <x-table.cell>
                        <x-action route-name="dashboard.admin.employees" :id="$employee->id">
                            <x-action.detail />
                            <x-action.update />
                            <x-action.delete />
                        </x-action>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-table.body>
    </x-table>
@endsection
