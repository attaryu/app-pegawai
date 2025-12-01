@extends('layouts.dashboard')
@section('title', 'Tambah Data Departemen')

@section('content')
    <x-card>
        <x-header title="Tambah Data Departemen" />

        <form action="{{ route('dashboard.admin.departments.store') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <fieldset class="space-y-4">
                <x-input id="nama_departemen" name="nama_departemen" error="{{ $errors->first('nama_departemen') }}"
                    label="Nama Departemen" placeholder="Masukkan nama departemen" />
            </fieldset>

            <div class="flex gap-4">
                <x-button type="reset" variant="secondary" class="ml-auto">Reset</x-button>
                <x-button type="submit">Simpan</x-button>
            </div>
        </form>
    </x-card>
@endsection
