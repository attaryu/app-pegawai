@extends('layouts.dashboard')
@section('title', 'Profile')

@php
    $role = auth()->user()->role->name;
@endphp

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex gap-4 items-center">
            <x-text as="h1" variant="h2">My Profile</x-text>
        </div>

        @if (session('success'))
            <x-alert variant="success" dismissible>
                {{ session('success') }}
            </x-alert>
        @endif

        @if (session('error'))
            <x-alert variant="danger" dismissible>
                {{ session('error') }}
            </x-alert>
        @endif

        {{-- Profile Information Card --}}
        <x-card>
            <div class="flex justify-between items-center mb-6">
                <x-text as="h3" variant="h4">Profile Information</x-text>
                <x-button as="a" href="{{ route('dashboard.employee.profile.edit') }}" variant="primary" size="sm">
                    <i class="fa-solid fa-pen"></i>
                    Update Profile
                </x-button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-text as="label" class="text-gray-500 text-sm">Full Name</x-text>
                    <x-text as="p" class="font-medium">{{ $employee->nama_lengkap }}</x-text>
                </div>

                <div>
                    <x-text as="label" class="text-gray-500 text-sm">Email</x-text>
                    <x-text as="p" class="font-medium">{{ $employee->email }}</x-text>
                </div>

                <div>
                    <x-text as="label" class="text-gray-500 text-sm">Phone Number</x-text>
                    <x-text as="p" class="font-medium">{{ $employee->nomor_telepon }}</x-text>
                </div>

                <div>
                    <x-text as="label" class="text-gray-500 text-sm">Date of Birth</x-text>
                    <x-text as="p" class="font-medium">{{ \Carbon\Carbon::parse($employee->tanggal_lahir)->format('d F Y') }}</x-text>
                </div>

                <div>
                    <x-text as="label" class="text-gray-500 text-sm">Department</x-text>
                    <x-text as="p" class="font-medium">{{ $employee->department->nama_departemen ?? '-' }}</x-text>
                </div>

                <div>
                    <x-text as="label" class="text-gray-500 text-sm">Position</x-text>
                    <x-text as="p" class="font-medium">{{ $employee->position->nama_jabatan ?? '-' }}</x-text>
                </div>

                <div>
                    <x-text as="label" class="text-gray-500 text-sm">Join Date</x-text>
                    <x-text as="p" class="font-medium">{{ \Carbon\Carbon::parse($employee->tanggal_masuk)->format('d F Y') }}</x-text>
                </div>

                <div>
                    <x-text as="label" class="text-gray-500 text-sm">Status</x-text>
                    <x-badge variant="{{ $employee->status === 'aktif' ? 'success' : 'danger' }}">
                        {{ ucfirst($employee->status) }}
                    </x-badge>
                </div>

                <div class="md:col-span-2">
                    <x-text as="label" class="text-gray-500 text-sm">Address</x-text>
                    <x-text as="p" class="font-medium">{{ $employee->alamat }}</x-text>
                </div>
            </div>
        </x-card>

        {{-- Password Change Card --}}
        <x-card>
            <div class="flex justify-between items-center mb-6">
                <x-text as="h3" variant="h4">Password & Security</x-text>
                <x-button as="a" href="{{ route('dashboard.employee.password.edit') }}" variant="secondary" size="sm">
                    <i class="fa-solid fa-key"></i>
                    Change Password
                </x-button>
            </div>

            <div>
                <x-text as="p" class="text-gray-600">
                    Keep your account secure by using a strong password and changing it regularly.
                </x-text>
            </div>
        </x-card>
    </div>
@endsection
