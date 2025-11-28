{{-- Employee Info --}}
<x-card>
    <div class="flex items-center gap-6">
        <div class="w-20 h-20 bg-brand-primary/10 rounded-full flex items-center justify-center">
            <i class="fa-solid fa-user text-4xl text-body"></i>
        </div>
        <div class="flex-1">
            <x-text as="h3" variant="h4">{{ $employee->nama_lengkap }}</x-text>
            <x-text as="p" class="text-body-secondary mt-1">
                {{ $employee->position->nama_jabatan }} • {{ $employee->department->nama_departemen }}
            </x-text>
            <div class="flex gap-4 mt-2">
                <x-badge :variant="$employee->status === 'aktif' ? 'success' : 'danger'">
                    {{ ucfirst($employee->status) }}
                </x-badge>
                <x-text as="small" class="text-body-secondary">
                    <i class="fa-solid fa-calendar"></i>
                    Joined {{ date('d M Y', strtotime($employee->tanggal_masuk)) }}
                </x-text>
            </div>
        </div>
    </div>
</x-card>

{{-- Attendance Check In/Out --}}
<x-card>
    <div class="flex items-center justify-between">
        <div>
            <x-text as="h3" variant="h4">Attendance</x-text>
            <x-text as="p" class="text-body-secondary mt-1">
                {{ now()->format('l, d F Y') }} • {{ now()->format('H:i') }}
            </x-text>

            @if($todayAttendance)
                <div class="flex gap-4 mt-3">
                    <div>
                        <x-text as="small" class="text-body-secondary">Check In</x-text>
                        <x-text as="p" class="font-semibold text-success">
                            <i class="fa-solid fa-clock"></i>
                            {{ date('H:i', strtotime($todayAttendance->waktu_masuk)) }}
                        </x-text>
                    </div>
                    @if($todayAttendance->waktu_keluar)
                        <div>
                            <x-text as="small" class="text-body-secondary">Check Out</x-text>
                            <x-text as="p" class="font-semibold text-danger">
                                <i class="fa-solid fa-clock"></i>
                                {{ date('H:i', strtotime($todayAttendance->waktu_keluar)) }}
                            </x-text>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex gap-3">
            @if($canCheckIn)
                <form action="{{ route('dashboard.employee.attendance.checkin') }}" method="POST">
                    @csrf
                    <x-button type="submit" variant="success">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        Check In
                    </x-button>
                </form>
            @elseif($canCheckOut)
                <form action="{{ route('dashboard.employee.attendance.checkout') }}" method="POST">
                    @csrf
                    <x-button type="submit" variant="danger">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Check Out
                    </x-button>
                </form>
            @else
                <x-button variant="secondary" disabled>
                    @if($todayAttendance && $todayAttendance->waktu_keluar)
                        <i class="fa-solid fa-check-circle"></i>
                        Completed
                    @elseif($todayAttendance)
                        <i class="fa-solid fa-clock"></i>
                        Waiting Check Out
                    @elseif(!now()->isWeekday())
                        <i class="fa-solid fa-calendar-xmark"></i>
                        Weekend
                    @else
                        <i class="fa-solid fa-lock"></i>
                        Not Available (7-9 AM)
                    @endif
                </x-button>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="mt-4 p-3 bg-success/10 border border-success/20 rounded-lg">
            <x-text as="small" class="text-success">
                <i class="fa-solid fa-check-circle"></i>
                {{ session('success') }}
            </x-text>
        </div>
    @endif

    @if(session('error'))
        <div class="mt-4 p-3 bg-danger/10 border border-danger/20 rounded-lg">
            <x-text as="small" class="text-danger">
                <i class="fa-solid fa-exclamation-circle"></i>
                {{ session('error') }}
            </x-text>
        </div>
    @endif
</x-card>
