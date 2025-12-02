<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $role = $user->role->name;

        if ($role === 'admin') {
            return $this->admin();
        } elseif ($role === 'employee') {
            return $this->employee($user->employee);
        }
    }

    private function admin()
    {
        // Total counts
        $totalEmployees = Employee::count();
        $totalPositions = Position::count();
        $activeEmployees = Employee::where('status', 'aktif')->count();
        $totalDepartments = Department::count();

        // Kehadiran hari ini
        $todayAttendance = Attendance::whereDate('tanggal', today())->count();

        // Total gaji bulan ini
        $currentMonth = now()->format('F');
        $totalSalaryThisMonth = Salary::where('bulan', $currentMonth)
            ->sum(DB::raw('gaji_pokok + gaji_tunjangan - potongan'));

        // Kehadiran hari ini (10 terakhir)
        $todayAttendances = Attendance::with(['employee.department', 'employee.position'])
            ->whereDate('tanggal', today())
            ->latest('waktu_masuk')
            ->take(10)
            ->get();

        // Statistik per departemen
        $departmentStats = Department::withCount('employees')
            ->with(['employees' => function ($q) use ($currentMonth) {
                $q->with(['salaries' => function ($q) use ($currentMonth) {
                    $q->where('bulan', $currentMonth);
                }]);
            }])
            ->get()
            ->map(function ($dept) {
                $totalSalary = $dept->employees->sum(function ($emp) {
                    return $emp->salaries->sum(function ($salary) {
                        return $salary->gaji_pokok + $salary->gaji_tunjangan - $salary->potongan;
                    });
                });

                $dept->total_salary = $totalSalary;
                return $dept;
            });

        // Data untuk grafik kehadiran mingguan
        $weeklyAttendance = Attendance::whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('DATE(tanggal) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Pastikan semua hari dalam seminggu ada (isi dengan 0 jika tidak ada data)
        $weekDays = collect();

        for ($i = 0; $i < 7; $i++) {
            $date = now()->startOfWeek()->addDays($i)->format('Y-m-d');
            $existingData = $weeklyAttendance->firstWhere('date', $date);

            $weekDays->push([
                'date' => $date,
                'count' => $existingData ? $existingData->count : 0
            ]);
        }

        // Data untuk grafik status karyawan
        $employeeStatus = [
            'active' => $activeEmployees,
            'inactive' => $totalEmployees - $activeEmployees
        ];

        return view('pages.dashboard.index', [
            'totalEmployees' => $totalEmployees,
            'activeEmployees' => $activeEmployees,
            'totalPositions' => $totalPositions,
            'totalDepartments' => $totalDepartments,
            'todayAttendance' => $todayAttendance,
            'totalSalaryThisMonth' => $totalSalaryThisMonth,
            'todayAttendances' => $todayAttendances,
            'departmentStats' => $departmentStats,
            'weeklyAttendance' => $weekDays,
            'employeeStatus' => $employeeStatus
        ]);
    }

    private function employee(Employee $employee)
    {
        $now = now();

        // Cek kehadiran hari ini
        $todayAttendance = Attendance::where('karyawan_id', $employee->id)
            ->whereDate('tanggal', $now->today())
            ->first();

        // Validasi waktu check in (7-9 pagi, hari kerja)
        $currentHour = $now->hour;
        $isWeekday = $now->isWeekday();
        $canCheckIn = $isWeekday && $currentHour >= 7 && $currentHour < 9 && !$todayAttendance;

        $canCheckOut = false;

        // Validasi check out (minimal 6 jam dan maksimal 12 jam setelah check in dan di hari yang sama)
        if ($todayAttendance && $todayAttendance->waktu_masuk && !$todayAttendance->waktu_keluar) {
            $checkInTime = \Carbon\Carbon::parse($todayAttendance->tanggal . ' ' . $todayAttendance->waktu_masuk);
            $minCheckOutTime = $checkInTime->copy()->addHours(6);
            $maxCheckOutTime = $checkInTime->copy()->addHours(12);
            $endOfDay = $now->copy()->endOfDay();

            $canCheckOut = $now->between($minCheckOutTime, $maxCheckOutTime) && $now->lessThanOrEqualTo($endOfDay);
        }

        return view('pages.dashboard.index', [
            'employee' => $employee,
            'todayAttendance' => $todayAttendance,
            'canCheckIn' => $canCheckIn,
            'canCheckOut' => $canCheckOut,
        ]);
    }
}
