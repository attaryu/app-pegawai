@extends('master')

@section('title', 'Login - App Pegawai')

@section('content')
    <div class="h-dvh flex items-center justify-center px-4">
        <x-card class="max-w-sm">
            <form action="#" method="POST" class="flex flex-col gap-4">
                @csrf

                <x-text as="h1" variant="h4" class="mb-4">Sign in to our platform</x-text>

                <x-input label="Your email" type="email" name="email" placeholder="example@company.com" required />

                <x-input label="Your password" type="password" name="password" placeholder="•••••••••" required />

                <x-button type="submit" class="w-full mt-4">
                    Login to your account
                </x-button>
            </form>
        </x-card>
    </div>
@endsection
