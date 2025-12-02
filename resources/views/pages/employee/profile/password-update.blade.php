@extends('layouts.dashboard')
@section('title', 'Change Password')

@php
    $role = auth()->user()->role->name;
@endphp

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex gap-4 items-center">
            <x-text as="h1" variant="h2">Change Password</x-text>
        </div>

        {{-- Change Password Form --}}
        <x-card>
            <form action="{{ route('dashboard.employee.password.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="space-y-4">
                    {{-- Current Password --}}
                    <x-input
                        label="Current Password"
                        type="password"
                        id="current_password"
                        name="current_password"
                        required
                    />

                    {{-- New Password --}}
                    <div>
                        <x-input
                            label="New Password"
                            type="password"
                            id="password"
                            name="password"
                            required
                        />
                        <p class="mt-1 text-sm text-gray-500">Password must be at least 8 characters long.</p>
                    </div>

                    {{-- Confirm New Password --}}
                    <x-input
                        label="Confirm New Password"
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                    />
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-4 justify-end border-t pt-6">
                    <x-button as="a" href="{{ route('dashboard.employee.profile.index') }}" variant="secondary">
                        Cancel
                    </x-button>
                    <x-button type="submit" variant="primary">
                        <i class="fa-solid fa-key"></i>
                        Update Password
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
