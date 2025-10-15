@extends('master')
@section('title', 'App Pegawai - Dashboard')

@section('content')
    {{-- Header Section --}}
    <section style="text-align: center; padding: 2rem 0;">
        <hgroup>
            <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">Dashboard</h1>
            <p style="color: var(--muted-color);">Sistem Manajemen Karyawan</p>
        </hgroup>
    </section>

    {{-- Bento Grid Layout --}}
    <section
        style="display: grid; grid-template-columns: repeat(4, 1fr); grid-template-rows: repeat(4, auto); gap: 1.5rem; margin-bottom: 2rem;">

        {{-- Total Karyawan - Large Card --}}
        <article
            style="grid-column: 1 / 3; grid-row: 1 / 3; padding: 2rem; background: var(--card-background-color); border-radius: 12px; border-left: 4px solid var(--primary); border: 1px solid #694D00">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div>
                    <h2 style="font-size: 3rem; color: var(--primary); margin: 0; line-height: 1;">
                        {{ \App\Models\Employee::count() }}</h2>
                    <p style="color: var(--muted-color); margin: 0.5rem 0 0 0;">Total Karyawan</p>
                </div>
                <i class="fa-solid fa-users" style="font-size: 2rem; color: var(--primary); opacity: 0.7;"></i>
            </div>
            <div style="margin-top: 2rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="font-size: 0.9rem; color: var(--muted-color);">Aktif</span>
                    <span
                        style="font-size: 0.9rem; font-weight: bold;">{{ \App\Models\Employee::where('status', 'aktif')->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="font-size: 0.9rem; color: var(--muted-color);">Tidak Aktif</span>
                    <span
                        style="font-size: 0.9rem; font-weight: bold;">{{ \App\Models\Employee::where('status', 'nonaktif')->count() }}</span>
                </div>
            </div>
            <footer style="margin-top: 1.5rem;">
                <a href="{{ route('employees.index') }}" style="text-decoration: none; font-size: 0.9rem;">Kelola Karyawan
                    →</a>
            </footer>
        </article>

        {{-- Departemen --}}
        <article
            style="grid-column: 3; grid-row: 1; padding: 1.5rem; background: var(--card-background-color); border-radius: 12px; text-align: center; border: 1px solid #694D00">
            <i class="fa-solid fa-building" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 1rem;"></i>
            <h3 style="font-size: 2rem; color: var(--primary); margin: 0;">{{ \App\Models\Department::count() }}</h3>
            <p style="color: var(--muted-color); font-size: 0.9rem; margin: 0.5rem 0;">Departemen</p>
            <a href="{{ route('departments.index') }}" style="text-decoration: none; font-size: 0.8rem;">Lihat →</a>
        </article>

        {{-- Posisi/Jabatan --}}
        <article
            style="grid-column: 4; grid-row: 1; padding: 1.5rem; background: var(--card-background-color); border-radius: 12px; text-align: center; border: 1px solid #694D00">
            <i class="fa-solid fa-briefcase" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 1rem;"></i>
            <h3 style="font-size: 2rem; color: var(--primary); margin: 0;">{{ \App\Models\Position::count() }}</h3>
            <p style="color: var(--muted-color); font-size: 0.9rem; margin: 0.5rem 0;">Posisi</p>
            <a href="{{ route('positions.index') }}" style="text-decoration: none; font-size: 0.8rem;">Lihat →</a>
        </article>

        {{-- Kehadiran Hari Ini --}}
        <article
            style="grid-column: 3 / 5; grid-row: 2; padding: 1.5rem; background: var(--card-background-color); border-radius: 12px; border: 1px solid #694D00">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h4 style="margin: 0; font-size: 1.1rem;">Kehadiran Hari Ini</h4>
                <i class="fa-solid fa-clock" style="color: var(--primary);"></i>
            </div>
            <div class="grid" style="gap: 1rem;">
                <div style="text-align: center;">
                    <span
                        style="font-size: 1.5rem; font-weight: bold; color: #28a745;">{{ \App\Models\Attendance::whereDate('tanggal', today())->where('status', 'hadir')->count() }}</span>
                    <p style="font-size: 0.8rem; color: var(--muted-color); margin: 0;">Hadir</p>
                </div>
                <div style="text-align: center;">
                    <span
                        style="font-size: 1.5rem; font-weight: bold; color: #ffc107;">{{ \App\Models\Attendance::whereDate('tanggal', today())->whereIn('status', ['izin', 'sakit'])->count() }}</span>
                    <p style="font-size: 0.8rem; color: var(--muted-color); margin: 0;">Izin/Sakit</p>
                </div>
            </div>
            <footer style="margin-top: 1rem;">
                <a href="{{ route('attendances.index') }}" style="text-decoration: none; font-size: 0.8rem;">Lihat Semua
                    →</a>
            </footer>
        </article>

        {{-- Gaji Bulan Ini --}}
        <article
            style="grid-column: 1; grid-row: 3; padding: 1.5rem; background: var(--card-background-color); border-radius: 12px; border: 1px solid #694D00">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h4 style="margin: 0; font-size: 1rem;">Gaji Bulan Ini</h4>
                <i class="fa-solid fa-money-bill-wave" style="color: var(--primary);"></i>
            </div>
            <p style="font-size: 1.5rem; font-weight: bold; color: var(--primary); margin: 0;">
                {{ \App\Models\Salary::whereMonth('created_at', now()->month)->count() }}
            </p>
            <p style="font-size: 0.8rem; color: var(--muted-color); margin: 0.5rem 0;">Record Gaji</p>
            <footer>
                <a href="{{ route('salaries.index') }}" style="text-decoration: none; font-size: 0.8rem;">Kelola →</a>
            </footer>
        </article>

        {{-- Statistik Departemen --}}
        <article
            style="grid-column: 2; grid-row: 3; padding: 1.5rem; background: var(--card-background-color); border-radius: 12px; border: 1px solid #694D00">
            <h4 style="margin: 0 0 1rem 0; font-size: 1rem;">Top Departemen</h4>
            @php
                $topDepartments = \App\Models\Department::withCount('employees')->orderBy('employees_count', 'desc')->limit(3)->get();
            @endphp
            @foreach($topDepartments as $dept)
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="font-size: 0.8rem;">{{ \Str::limit($dept->nama_departemen, 12) }}</span>
                    <span style="font-size: 0.8rem; font-weight: bold;">{{ $dept->employees_count }}</span>
                </div>
            @endforeach
        </article>

        {{-- Status Overview --}}
        <article
            style="grid-column: 3 / 5; grid-row: 3; padding: 1.5rem; background: var(--card-background-color); border-radius: 12px; border: 1px solid #694D00">
            <h4 style="margin: 0 0 1rem 0; font-size: 1rem;">Status Karyawan Overview</h4>
            <div class="grid" style="gap: 1rem;">
                <div style="text-align: center; padding: 1rem; background: rgba(40, 167, 69, 0.1); border-radius: 8px;">
                    <span
                        style="font-size: 1.2rem; font-weight: bold; color: #28a745;">{{ \App\Models\Employee::where('status', 'aktif')->count() }}</span>
                    <p style="font-size: 0.8rem; color: var(--muted-color); margin: 0;">Aktif</p>
                </div>
                <div style="text-align: center; padding: 1rem; background: rgba(220, 53, 69, 0.1); border-radius: 8px;">
                    <span
                        style="font-size: 1.2rem; font-weight: bold; color: #dc3545;">{{ \App\Models\Employee::where('status', 'nonaktif')->count() }}</span>
                    <p style="font-size: 0.8rem; color: var(--muted-color); margin: 0;">Non-Aktif</p>
                </div>
            </div>
        </article>

        {{-- Quick Actions --}}
        <article
            style="grid-column: 1 / 5; grid-row: 4; padding: 1.5rem; background: var(--card-background-color); border-radius: 12px;">
            <h4 style="margin: 0 0 1.5rem 0; text-align: center;">Aksi Cepat</h4>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('employees.create') }}" role="button"
                    style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; font-size: 0.9rem;">
                    <i class="fa-solid fa-user-plus"></i>
                    Tambah Karyawan
                </a>
                <a href="{{ route('departments.create') }}" role="button" class="outline"
                    style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; font-size: 0.9rem;">
                    <i class="fa-solid fa-building-circle-plus"></i>
                    Tambah Departemen
                </a>
                <a href="{{ route('positions.create') }}" role="button" class="outline"
                    style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; font-size: 0.9rem;">
                    <i class="fa-solid fa-briefcase"></i>
                    Tambah Posisi
                </a>
                <a href="{{ route('attendances.create') }}" role="button" class="outline"
                    style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; font-size: 0.9rem;">
                    <i class="fa-solid fa-clock"></i>
                    Input Kehadiran
                </a>
            </div>
        </article>

    </section>

    <style>
        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            section:nth-child(2) {
                grid-template-columns: 1fr !important;
                grid-template-rows: auto !important;
            }

            section:nth-child(2) article {
                grid-column: 1 !important;
                grid-row: auto !important;
            }
        }

        /* Responsive untuk tablet */
        @media (max-width: 1024px) and (min-width: 769px) {
            section:nth-child(2) {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
    </style>
@endsection