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
        $employee = $user->employee;

        if ($role === 'admin') {
            return $this->admin();
        } elseif ($role === 'employee') {
            // Implementasi untuk dashboard karyawan jika diperlukan
            return $this->employee($employee);
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
        if (!$employee) {
            return redirect()->route('dashboard.index')->with('error', 'Employee data not found');
        }

        // Total gaji yang sudah diterima
        $totalSalaryEarned = Salary::where('karyawan_id', $employee->id)
            ->sum(DB::raw('gaji_pokok + gaji_tunjangan - potongan'));

        // Gaji bulan ini
        $currentMonth = now()->format('F');
        $currentMonthSalary = Salary::where('karyawan_id', $employee->id)
            ->where('bulan', $currentMonth)
            ->first();

        $monthlySalary = $currentMonthSalary
            ? ($currentMonthSalary->gaji_pokok + $currentMonthSalary->gaji_tunjangan - $currentMonthSalary->potongan)
            : 0;

        // Total kehadiran
        $totalAttendance = Attendance::where('karyawan_id', $employee->id)->count();

        // Kehadiran bulan ini
        $monthlyAttendance = Attendance::where('karyawan_id', $employee->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        // Status kehadiran bulan ini
        $attendanceStatus = Attendance::where('karyawan_id', $employee->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Grafik kehadiran 3 bulan terakhir
        $monthlyAttendanceChart = collect();
        for ($i = 2; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = Attendance::where('karyawan_id', $employee->id)
                ->whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->where('status', 'hadir')
                ->count();

            $monthlyAttendanceChart->push([
                'month' => $date->format('F'),
                'count' => $count
            ]);
        }

        // Riwayat gaji (6 bulan terakhir)
        $salaryHistory = Salary::where('karyawan_id', $employee->id)
            ->latest('id')
            ->take(6)
            ->get();

        // Kehadiran terkini (10 terakhir)
        $recentAttendances = Attendance::where('karyawan_id', $employee->id)
            ->latest('tanggal')
            ->take(10)
            ->get();

        return view('pages.dashboard.index', [
            'employee' => $employee,
            'totalSalaryEarned' => $totalSalaryEarned,
            'monthlySalary' => $monthlySalary,
            'totalAttendance' => $totalAttendance,
            'monthlyAttendance' => $monthlyAttendance,
            'attendanceStatus' => $attendanceStatus,
            'monthlyAttendanceChart' => $monthlyAttendanceChart,
            'salaryHistory' => $salaryHistory,
            'recentAttendances' => $recentAttendances
        ]);
    }
}
