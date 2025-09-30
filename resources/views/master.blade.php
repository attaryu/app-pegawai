<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.amber.min.css">
    <title>@yield('title', 'App Pegawai')</title>
</head>

<body>
    <main class="container">
        <nav>
            <p style="font-size: 1.2rem;">
                <strong>@yield('nav-title', 'App Pegawai')</strong>
            </p>

            <ul style="font-size:0.9rem">
                <li><a href="{{ url('/employees') }}">Employee</a></li>
                <li><a href="{{ url('/departments') }}">Department</a></li>
                <li><a href="{{ url('/attendances') }}">Attendance</a></li>
                <li><a href="{{ url('/reports') }}">Report</a></li>
                <li><a href="{{ url('/settings') }}">Settings</a></li>
            </ul>
        </nav>

        @yield('content')
    </main>

    <footer>
        <p style="text-align: center; margin-top: 2rem; font-size: 0.9rem;">
            &copy; @yield('year', '2025') App Pegawai
        </p>
    </footer>
</body>

</html>
