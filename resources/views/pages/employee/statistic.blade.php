@extends('layouts.dashboard')
@section('title', 'Statistic')

@php
    $role = auth()->user()->role->name;
@endphp

@section('content')
    <div class="space-y-4">
        <div class="flex gap-4 items-center">
            <x-text as="h1" variant="h2">Your Statistic</x-text>

            <x-badge class="h-fit" variant="info">
                <i class="fa-solid fa-calendar-day"></i>

                {{ date('d F Y') }}
            </x-badge>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Gaji Diterima --}}
            <x-summary-card highlight="Rp {{ number_format($totalSalaryEarned, 0, ',', '.') }}" label="Total Earnings"
                small="All time" icon="fa-wallet" />

            {{-- Gaji Bulan Ini --}}
            <x-summary-card highlight="Rp {{ number_format($monthlySalary, 0, ',', '.') }}" label="This Month Salary"
                small="{{ now()->format('F Y') }}" icon="fa-money-bill-wave" />

            {{-- Total Kehadiran --}}
            <x-summary-card highlight="{{ $totalAttendance }}" label="Total Attendance" small="All time"
                icon="fa-clipboard-check" />

            {{-- Kehadiran Bulan Ini --}}
            <x-summary-card highlight="{{ $monthlyAttendance }}" label="Monthly Attendance"
                small="{{ now()->format('F Y') }}" icon="fa-calendar-check" />
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            {{-- Grafik Kehadiran 3 Bulan Terakhir --}}
            <x-card>
                <x-text as="h3" variant="h4" class="mb-6">Attendance Trend (Last 3 Months)</x-text>
                <div id="attendanceTrendChart"></div>
            </x-card>

            {{-- Status Kehadiran Bulan Ini --}}
            <x-card>
                <x-text as="h3" variant="h4" class="mb-6">This Month Attendance Status</x-text>
                <div id="attendanceStatusChart"></div>
            </x-card>
        </div>

        {{-- Salary History --}}
        <x-card>
            <div class="flex justify-between items-center mb-4">
                <x-text as="h3" variant="h4">Salary History</x-text>
            </div>

            @if($salaryHistory->isEmpty())
                <div class="text-center py-8 text-body-secondary">
                    <i class="fa-solid fa-inbox text-4xl mb-2"></i>
                    <x-text as="p">No salary data available</x-text>
                </div>
            @else
                <x-table.table>
                    <x-table.head>
                        <x-table.heading>Month</x-table.heading>
                        <x-table.heading>Basic Salary</x-table.heading>
                        <x-table.heading>Allowance</x-table.heading>
                        <x-table.heading>Deduction</x-table.heading>
                        <x-table.heading>Total</x-table.heading>
                    </x-table.head>
                    <x-table.body>
                        @foreach($salaryHistory as $salary)
                            @php
                                $total = $salary->gaji_pokok + $salary->gaji_tunjangan - $salary->potongan;
                            @endphp
                            <x-table.row>
                                <x-table.cell>{{ $salary->bulan }}</x-table.cell>
                                <x-table.cell>Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}</x-table.cell>
                                <x-table.cell>Rp {{ number_format($salary->gaji_tunjangan, 0, ',', '.') }}</x-table.cell>
                                <x-table.cell>Rp {{ number_format($salary->potongan, 0, ',', '.') }}</x-table.cell>
                                <x-table.cell>
                                    <x-text as="p" class="font-semibold text-brand-primary">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </x-text>
                                </x-table.cell>
                            </x-table.row>
                        @endforeach
                    </x-table.body>
                </x-table.table>
            @endif
        </x-card>

        {{-- Recent Attendance --}}
        <x-card>
            <div class="flex justify-between items-center mb-4">
                <x-text as="h3" variant="h4">Recent Attendance</x-text>
            </div>

            @if($recentAttendances->isEmpty())
                <div class="text-center py-8 text-body-secondary">
                    <i class="fa-solid fa-inbox text-4xl mb-2"></i>
                    <x-text as="p">No attendance data available</x-text>
                </div>
            @else
                <x-table.table>
                    <x-table.head>
                        <x-table.heading>Date</x-table.heading>
                        <x-table.heading>Check In</x-table.heading>
                        <x-table.heading>Check Out</x-table.heading>
                        <x-table.heading>Status</x-table.heading>
                    </x-table.head>
                    <x-table.body>
                        @foreach($recentAttendances as $attendance)
                            <x-table.row>
                                <x-table.cell>{{ date('d M Y', strtotime($attendance->tanggal)) }}</x-table.cell>
                                <x-table.cell>{{ $attendance->waktu_masuk ? date('H:i', strtotime($attendance->waktu_masuk)) : '-' }}</x-table.cell>
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
                </x-table.table>
            @endif
        </x-card>
    </div>
@endsection

@push('scripts')
    <script>
        // Data dari backend
        const monthlyAttendanceData = @json($monthlyAttendanceChart);
        const attendanceStatusData = @json($attendanceStatus);

        // Grafik Kehadiran 3 Bulan Terakhir
        const attendanceTrendOptions = {
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Present',
                data: monthlyAttendanceData.map(item => item.count)
            }],
            xaxis: {
                categories: monthlyAttendanceData.map(item => item.month)
            },
            colors: ['#3b82f6'],
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    columnWidth: '60%',
                }
            },
            dataLabels: {
                enabled: true
            },
            grid: {
                borderColor: '#e5e7eb',
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return Math.floor(val);
                    }
                }
            }
        };

        const attendanceTrendChart = new ApexCharts(document.querySelector("#attendanceTrendChart"), attendanceTrendOptions);
        attendanceTrendChart.render();

        // Grafik Status Kehadiran Bulan Ini
        const statusLabels = [];
        const statusValues = [];
        const statusColors = {
            'hadir': '#10b981',
            'izin': '#f59e0b',
            'sakit': '#3b82f6',
            'alpha': '#ef4444'
        };

        Object.keys(attendanceStatusData).forEach(status => {
            statusLabels.push(status.charAt(0).toUpperCase() + status.slice(1));
            statusValues.push(attendanceStatusData[status]);
        });

        const attendanceStatusOptions = {
            chart: {
                height: 320,
                width: "100%",
                type: "donut",
            },
            series: statusValues,
            labels: statusLabels,
            colors: Object.keys(attendanceStatusData).map(status => statusColors[status] || '#6b7280'),
            legend: {
                position: 'bottom'
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
                                label: "Total",
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
            stroke: {
                colors: ["transparent"],
                lineCap: "",
            },
            dataLabels: {
                enabled: false,
            },
        };

        const attendanceStatusChart = new ApexCharts(document.querySelector("#attendanceStatusChart"), attendanceStatusOptions);
        attendanceStatusChart.render();
    </script>
@endpush
