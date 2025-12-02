@extends('layouts.main')

@section('title', 'Login - App Pegawai')

@section('content')
    <div class="h-dvh flex items-center justify-center px-4">
        <div class="max-w-sm w-full space-y-4">
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

            <x-card>
                <form action="{{ route('login.process') }}" method="POST" class="flex flex-col gap-4">
                    @csrf

                    <x-text as="h1" variant="h4" class="mb-4">Sign in to our platform</x-text>

                    <x-input label="Email" type="email" name="email" placeholder="example@company.com" required />

                    <x-input label="Password" type="password" name="password" placeholder="Your password" required />

                    <x-checkbox label="Remember me" id="remember" name="remember" />

                    <x-button type="submit" class="w-full mt-4">
                        Login to your account
                    </x-button>
                </form>
            </x-card>
        </div>
    </div>
@endsection
