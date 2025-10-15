@extends('master')
@section('title', 'App Pegawai - Sistem Manajemen Karyawan')

@section('content')
    {{-- Hero Section --}}
    <section style="text-align: center; padding: 4rem 0;">
        <hgroup>
            <h1 style="font-size: 3rem; margin-bottom: 1rem;">App Pegawai</h1>
            <p style="font-size: 1.2rem; color: var(--muted-color);">
                Sistem Manajemen Karyawan Modern untuk Perusahaan Anda
            </p>
        </hgroup>
        
        <p style="margin: 2rem 0; font-size: 1rem; line-height: 1.6;">
            Kelola data karyawan, absensi, dan penggajian dengan mudah dan efisien. 
            Dirancang khusus untuk memenuhi kebutuhan manajemen SDM perusahaan modern.
        </p>

        <div style="margin-top: 2rem;">
            <a href="{{ route('employees.index') }}" role="button" style="margin: 0 0.5rem;">
                Kelola Karyawan
            </a>
            <a href="{{ route('departments.index') }}" role="button" class="outline" style="margin: 0 0.5rem;">
                Lihat Departemen
            </a>
        </div>
    </section>

    {{-- Features Section --}}
    <section style="margin: 4rem 0;">
        <h2 style="text-align: center; margin-bottom: 3rem;">Fitur Utama</h2>
        
        <div class="grid" style="gap: 2rem;">
            {{-- Employee Management --}}
            <article style="padding: 2rem; border-radius: 8px; background: var(--card-background-color);">
                <header>
                    <h3 style="margin-bottom: 1rem;">
                        <i class="fa-solid fa-users" style="color: var(--primary); margin-right: 0.5rem;"></i>
                        Manajemen Karyawan
                    </h3>
                </header>
                <p style="margin-bottom: 1.5rem; color: var(--muted-color);">
                    Kelola data lengkap karyawan mulai dari informasi pribadi, jabatan, hingga status kepegawaian.
                </p>
                <footer>
                    <a href="{{ route('employees.index') }}" style="text-decoration: none;">
                        Lihat Karyawan →
                    </a>
                </footer>
            </article>

            {{-- Department Management --}}
            <article style="padding: 2rem; border-radius: 8px; background: var(--card-background-color);">
                <header>
                    <h3 style="margin-bottom: 1rem;">
                        <i class="fa-solid fa-building" style="color: var(--primary); margin-right: 0.5rem;"></i>
                        Departemen & Jabatan
                    </h3>
                </header>
                <p style="margin-bottom: 1.5rem; color: var(--muted-color);">
                    Atur struktur organisasi perusahaan dengan manajemen departemen dan posisi jabatan.
                </p>
                <footer>
                    <a href="{{ route('departments.index') }}" style="text-decoration: none;">
                        Kelola Departemen →
                    </a>
                </footer>
            </article>

            {{-- Attendance System --}}
            <article style="padding: 2rem; border-radius: 8px; background: var(--card-background-color);">
                <header>
                    <h3 style="margin-bottom: 1rem;">
                        <i class="fa-solid fa-clock" style="color: var(--primary); margin-right: 0.5rem;"></i>
                        Sistem Absensi
                    </h3>
                </header>
                <p style="margin-bottom: 1.5rem; color: var(--muted-color);">
                    Pantau kehadiran karyawan dengan sistem absensi yang akurat dan mudah digunakan.
                </p>
                <footer>
                    <span style="color: var(--muted-color); font-style: italic;">
                        Segera Hadir
                    </span>
                </footer>
            </article>
        </div>
    </section>

    {{-- Stats Section --}}
    <section style="margin: 4rem 0; padding: 3rem 0; background: var(--card-background-color); border-radius: 12px;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Statistik Sistem</h2>
        
        <div class="grid" style="gap: 2rem; text-align: center;">
            <div>
                <h3 style="font-size: 2.5rem; color: var(--primary); margin-bottom: 0.5rem;">
                    {{ \App\Models\Employee::count() }}
                </h3>
                <p style="color: var(--muted-color);">Total Karyawan</p>
            </div>
            
            <div>
                <h3 style="font-size: 2.5rem; color: var(--primary); margin-bottom: 0.5rem;">
                    {{ \App\Models\Department::count() }}
                </h3>
                <p style="color: var(--muted-color);">Departemen Aktif</p>
            </div>
            
            <div>
                <h3 style="font-size: 2.5rem; color: var(--primary); margin-bottom: 0.5rem;">
                    {{ \App\Models\Employee::where('status', 'aktif')->count() }}
                </h3>
                <p style="color: var(--muted-color);">Karyawan Aktif</p>
            </div>
        </div>
    </section>

    {{-- Quick Actions --}}
    <section style="margin: 4rem 0;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Aksi Cepat</h2>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('employees.create') }}" role="button" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-user-plus"></i>
                Tambah Karyawan
            </a>
            
            <a href="{{ route('departments.create') }}" role="button" class="outline" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-building-circle-plus"></i>
                Tambah Departemen
            </a>
            
            <a href="#" role="button" class="outline" style="display: inline-flex; align-items: center; gap: 0.5rem;" onclick="alert('Fitur segera hadir!')">
                <i class="fa-solid fa-chart-line"></i>
                Lihat Laporan
            </a>
        </div>
    </section>
@endsection
