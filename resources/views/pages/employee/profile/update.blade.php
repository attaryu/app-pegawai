@extends('layouts.dashboard')
@section('title', 'Update Profile')

@php
    $role = auth()->user()->role->name;
@endphp

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex gap-4 items-center">
            <x-text as="h1" variant="h2">Update Profile</x-text>
        </div>

        {{-- Update Profile Form --}}
        <x-card>
            <form action="{{ route('dashboard.employee.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Full Name --}}
                    <x-input
                        label="Full Name"
                        type="text"
                        id="nama_lengkap"
                        name="nama_lengkap"
                        :value="old('nama_lengkap', $employee->nama_lengkap)"
                        required
                    />

                    {{-- Date of Birth --}}
                    <x-date-picker
                        label="Date of Birth"
                        id="tanggal_lahir"
                        name="tanggal_lahir"
                        :value="$employee->tanggal_lahir"
                        required
                    />

                    {{-- Email --}}
                    <x-input
                        label="Email"
                        type="email"
                        id="email"
                        name="email"
                        :value="old('email', $employee->email)"
                        required
                    />

                    {{-- Phone Number --}}
                    <x-input
                        label="Phone Number"
                        type="text"
                        id="nomor_telepon"
                        name="nomor_telepon"
                        :value="old('nomor_telepon', $employee->nomor_telepon)"
                        required
                    />

                    {{-- Address --}}
                    <x-input
                        label="Address"
                        type="textarea"
                        id="alamat"
                        name="alamat"
                        :value="old('alamat', $employee->alamat)"
                        required
                        class="md:col-span-2"
                    />
                </div>

                {{-- Read-only Information --}}
                <div class="border-t pt-6">
                    <x-text as="h4" variant="h5" class="mb-4 text-gray-700">Company Information (Read-only)</x-text>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-text as="label" class="text-gray-500 text-sm">Department</x-text>
                            <x-text as="p" class="font-medium text-gray-600">{{ $employee->department->nama_departemen ?? '-' }}</x-text>
                        </div>

                        <div>
                            <x-text as="label" class="text-gray-500 text-sm">Position</x-text>
                            <x-text as="p" class="font-medium text-gray-600">{{ $employee->position->nama_jabatan ?? '-' }}</x-text>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-4 justify-end border-t pt-6">
                    <x-button as="a" href="{{ route('dashboard.employee.profile.index') }}" variant="secondary">
                        Cancel
                    </x-button>
                    <x-button type="submit" variant="primary">
                        <i class="fa-solid fa-save"></i>
                        Save Changes
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
