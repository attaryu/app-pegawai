@extends('layouts.main')
@section('title', 'App Pegawai - Dashboard')

@section('content')
    <section class="w-full h-dvh flex items-center justify-center gap-2 flex-col px-4 text-center bg-neutral-primary">
        <x-text as="h1">Welcome to AllStaff</x-text>

        <x-text as="p" class="mt-2 max-w-xl mx-auto">
            Your all-in-one employee management solution. Streamline your HR processes and enhance productivity with
            AllStaff.
        </x-text>

        <div class="flex items-center justify-center gap-2 mt-6">
            <x-button href="{{ route('dashboard.index') }}" variant="primary" class="mr-2">
                Dashboard
            </x-button>
        </div>
    </section>
@endsection
