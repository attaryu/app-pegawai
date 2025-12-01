@extends('layouts.dashboard')
@section('title', 'Edit Data Posisi')

@section('content')
    <x-card>
        <x-header title="Edit Data Posisi" />

        <form action="{{ route('dashboard.admin.positions.update', $position->id) }}" method="POST" class="mt-8 space-y-6">
            @csrf
            @method('PUT')

            <fieldset class="space-y-4">
                <div class="flex gap-4 w-full">
                    <x-input id="nama_jabatan" name="nama_jabatan" error="{{ $errors->first('nama_jabatan') }}"
                        label="Nama Jabatan" placeholder="Masukkan nama jabatan"
                        value="{{ old('nama_jabatan', $position->nama_jabatan) }}" class="w-full" />

                    <x-input id="gaji_pokok" name="gaji_pokok" error="{{ $errors->first('gaji_pokok') }}"
                        label="Gaji Pokok" placeholder="Masukkan gaji pokok" type="number"
                        value="{{ old('gaji_pokok', $position->gaji_pokok) }}" class="w-full" />
                </div>
            </fieldset>

            <div class="flex gap-4">
                <x-button type="reset" variant="secondary" class="ml-auto">Reset</x-button>
                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </x-card>
@endsection
