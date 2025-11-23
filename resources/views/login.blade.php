@extends('master')

@section('title', 'Login - App Pegawai')

@section('content')
    <div style="display: flex; align-items: center; justify-content: center; min-height: 80vh;">
        <article style="max-width: 400px; width: 100%;">
            <header>
                <h2 style="text-align: center; margin-bottom: 0.5rem;">Login</h2>
                <p style="text-align: center; color: var(--muted-color); font-size: 0.9rem;">
                    Masuk ke akun Anda
                </p>
            </header>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <label for="email">
                    Email
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="nama@example.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <small style="color: var(--del-color);">{{ $message }}</small>
                    @enderror
                </label>

                {{-- Password --}}
                <label for="password">
                    Password
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Password anda"
                        required
                    >
                    @error('password')
                        <small style="color: var(--del-color);">{{ $message }}</small>
                    @enderror
                </label>

                {{-- Submit Button --}}
                <button type="submit" style="width: 100%; margin-top: 1rem;">
                    Login
                </button>
            </form>
        </article>
    </div>
@endsection
