<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.amber.min.css">
    <script src="https://kit.fontawesome.com/994c85c9fb.js" crossorigin="anonymous"></script>
    <title>@yield('title', 'App Pegawai')</title>
</head>

<body>
    <main class="container">
        <nav>
            <p style="font-size: 1.2rem;">
                <strong>@yield('nav-title', 'App Pegawai')</strong>
            </p>

            <ul style="font-size:0.9rem">
                <li><a href="{{ route('employees.index') }}">Karyawan</a></li>
                <li><a href="{{ route('departments.index') }}">Departemen</a></li>
                <li><a href="{{ route('positions.index') }}">Posisi</a></li>
                <li><a href="{{ route('attendances.index') }}">Kehadiran</a></li>
                <li><a href="{{ route('salaries.index') }}">Gaji</a></li>
                {{-- <li><a href="{{ route('settings.index') }}">Pengaturan</a></li> --}}
            </ul>
        </nav>

        @yield('content')
    </main>

    <footer>
        <p style="text-align: center; margin-top: 2rem; font-size: 0.9rem;">
            &copy; @yield('year', '2025') App Pegawai
        </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
        </script>
    @stack('scripts')
</body>

</html>