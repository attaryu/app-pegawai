@extends('layouts.dashboard')
@section('title', 'Edit Data Departemen')

@section('content')
    <x-card>
        <x-header title="Edit Data Departemen" />

        <form action="{{ route('dashboard.admin.departments.update', $department->id) }}" method="POST" class="mt-8 space-y-6">
            @csrf
            @method('PUT')

            <fieldset class="space-y-4">
                <x-input id="nama_departemen" name="nama_departemen" error="{{ $errors->first('nama_departemen') }}"
                    label="Nama Departemen" placeholder="Masukkan nama departemen" value="{{ old('nama_departemen', $department->nama_departemen) }}" />
            </fieldset>

            <div class="flex gap-4">
                <x-button type="reset" variant="secondary" class="ml-auto">Reset</x-button>
                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </x-card>
@endsection
