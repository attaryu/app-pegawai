@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')
    <div class="space-y-4">
        <div class="flex gap-4 items-center">
            <x-text as="h1" variant="h2">Dashboard</x-text>

            <x-badge class="h-fit" variant="info">
                <i class="fa-solid fa-calendar-day"></i>

                {{ date('d F Y') }}
            </x-badge>
        </div>

        {{-- Total Gaji Bulan Ini --}}
        <x-summary-card highlight="Rp {{ number_format($totalSalaryThisMonth, 0, ',', '.') }}" label="Total Gaji Bulan Ini"
            icon="fa-sack-dollar" />

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Karyawan --}}
            <x-summary-card highlight="{{ $totalEmployees }}" label="Total Karyawan" small="{{ $activeEmployees }} Aktif"
                icon="fa-users" />

            {{-- Total Departemen --}}
            <x-summary-card highlight="{{ $totalDepartments }}" label="Total Departemen" icon="fa-building" />

            {{-- Total Jabatan --}}
            <x-summary-card highlight="{{ $totalPositions }}" label="Total Jabatan" icon="fa-briefcase" />

            {{-- Kehadiran Hari Ini --}}
            <x-summary-card highlight="{{ $todayAttendance }}" label="Hadir Hari Ini"
                small="dari {{ $totalEmployees }} karyawan" icon="fa-clipboard-check" />
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            {{-- Grafik Kehadiran Mingguan --}}
            <x-card>
                <x-text as="h3" variant="h4" class="mb-6">Kehadiran Mingguan</x-text>
                <div id="attendanceChart"></div>
            </x-card>

            {{-- Grafik Karyawan per Status --}}
            <x-card>
                <x-text as="h3" variant="h4" class="mb-6">Status Karyawan</x-text>
                <div id="employeeStatusChart"></div>
            </x-card>
        </div>

        {{-- Kehadiran Hari Ini Table --}}
        <x-card>
            <div class="flex justify-between items-center mb-4">
                <x-text as="h3" variant="h4">Kehadiran Hari Ini</x-text>

                <x-button href="{{ route('dashboard.admin.attendances.index') }}" variant="secondary" size="sm">
                    Lihat Semua
                </x-button>
            </div>

            @if($todayAttendances->isEmpty())
                <div class="text-center py-8 text-body-secondary">
                    <i class="fa-solid fa-inbox text-2xl mb-2 text-body"></i>
                    <x-text as="p">Belum ada data kehadiran hari ini</x-text>
                </div>
            @else
                <x-table>
                    <x-table.head>
                        <x-table.heading>Nama</x-table.heading>
                        <x-table.heading>Departemen</x-table.heading>
                        <x-table.heading>Jabatan</x-table.heading>
                        <x-table.heading>Waktu Masuk</x-table.heading>
                        <x-table.heading>Waktu Keluar</x-table.heading>
                        <x-table.heading>Status</x-table.heading>
                    </x-table.head>
                    <x-table.body>
                        @foreach($todayAttendances as $attendance)
                            <x-table.row>
                                <x-table.cell>{{ $attendance->employee->nama_lengkap }}</x-table.cell>
                                <x-table.cell>{{ $attendance->employee->department->nama_departemen }}</x-table.cell>
                                <x-table.cell>{{ $attendance->employee->position->nama_jabatan }}</x-table.cell>
                                <x-table.cell>{{ date('H:i', strtotime($attendance->waktu_masuk)) }}</x-table.cell>
                                <x-table.cell>{{ $attendance->waktu_keluar ? date('H:i', strtotime($attendance->waktu_keluar)) : '-' }}</x-table.cell>
                                <x-table.cell>
                                    @php
                                        $statusVariants = [
                                            'hadir' => 'success',
                                            'izin' => 'warning',
                                            'sakit' => 'info',
                                            'alpha' => 'danger'
                                        ];

                                        $variant = $statusVariants[$attendance->status] ?? 'default';
                                    @endphp
                                    <x-badge :variant="$variant">{{ ucfirst($attendance->status) }}</x-badge>
                                </x-table.cell>
                            </x-table.row>
                        @endforeach
                    </x-table.body>
                </x-table>
            @endif
        </x-card>

        {{-- Statistik per Departemen --}}
        <x-card>
            <x-text as="h3" variant="h4" class="mb-6">Ringkasan per Departemen</x-text>

            <div class="space-y-3">
                @foreach($departmentStats as $dept)
                    <div
                        class="flex justify-between items-center p-4 bg-neutral-secondary rounded-lg hover:bg-neutral-secondary/80 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="size-10 grid place-items-center">
                                <i class="fa-solid fa-building text-body text-2xl"></i>
                            </div>

                            <div>
                                <x-text as="p" class="font-semibold">{{ $dept->nama_departemen }}</x-text>
                                <x-text as="small" class="text-body-secondary">{{ $dept->employees_count }} Karyawan</x-text>
                            </div>
                        </div>

                        <div class="text-right">
                            <x-text as="p" class="font-semibold text-brand-primary">
                                Rp {{ number_format($dept->total_salary, 0, ',', '.') }}
                            </x-text>

                            <x-text as="small" class="text-body-secondary">Total Gaji Bulan Ini</x-text>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>
@endsection

@push('scripts')
    <script>
        // Data dari backend
        const weeklyAttendanceData = @json($weeklyAttendance);
        const employeeStatusData = @json($employeeStatus);

        // Grafik Kehadiran Mingguan
        const attendanceOptions = {
            chart: {
                type: 'bar',
                height: '300px',
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Attendances',
                data: weeklyAttendanceData.map(item => item.count)
            }],
            xaxis: {
                categories: weeklyAttendanceData.map(item => {
                    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    const date = new Date(item.date);
                    return days[date.getDay()];
                })
            },
            tooltip: {
                shared: true,
                intersect: false,
            },
            colors: ['#1C64F2'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "75%",
                    borderRadiusApplication: "end",
                    borderRadius: 4,
                },
            },
            states: {
                hover: {
                    filter: {
                        type: "darken",
                        value: 1,
                    },
                },
            },
            stroke: {
                show: true,
                width: 0,
                colors: ["transparent"],
            },
            grid: {
                show: true,
                strokeDashArray: 4,
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
        };

        const attendanceChart = new ApexCharts(document.querySelector("#attendanceChart"), attendanceOptions);
        attendanceChart.render();

        // Grafik Status Karyawan
        const statusOptions = {
            series: [employeeStatusData.active, employeeStatusData.inactive],
            labels: ['Aktif', 'Nonaktif'],
            colors: ['#1C64F2', '#C3DDFD'],
            legend: {
                position: 'bottom'
            },
            stroke: {
                colors: ["transparent"],
                lineCap: "",
            },
            chart: {
                height: 320,
                width: "100%",
                type: "donut",
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                offsetY: 20,
                            },
                            total: {
                                show: true,
                                label: "Karyawan",
                            },
                            value: {
                                show: true,
                                offsetY: -20,
                                fontSize: '32px',
                                fontWeight: 600,
                            },
                        },
                        size: "80%",
                    },
                },
            },
            dataLabels: {
                enabled: false,
            },

        };

        const statusChart = new ApexCharts(document.querySelector("#employeeStatusChart"), statusOptions);
        statusChart.render();
    </script>
@endpush