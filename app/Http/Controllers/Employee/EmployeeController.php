<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function statistic(Request $request)
    {
        $employee = $request->user()->employee;

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

        return view('pages.employee.statistic', [
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

    public function profile(Request $request)
    {
        $employee = Employee::with(['department', 'position'])
            ->where('id', $request->user()->employee->id)
            ->first();

        if (!$employee) {
            return redirect()->route('dashboard.index')->with('error', 'Employee data not found');
        }

        return view('pages.employee.profile.index', [
            'employee' => $employee,
            'user' => $request->user()
        ]);
    }

    public function editProfile(Request $request)
    {
        $employee = Employee::with(['department', 'position'])
            ->where('id', $request->user()->employee->id)
            ->first();

        if (!$employee) {
            return redirect()->route('dashboard.index')->with('error', 'Employee data not found');
        }

        return view('pages.employee.profile.update', [
            'employee' => $employee
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->route('dashboard.index')->with('error', 'Employee data not found');
        }

        $validated = $request->validate([
            'nomor_telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
        ]);

        $user->update(['email' => $validated['email']]);
        $employee->update($validated);

        return redirect()->route('dashboard.employee.profile.index')->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed|min:8',
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('dashboard.employee.profile.index')->with('success', 'Password updated successfully');
    }

    public function editPassword()
    {
        return view('pages.employee.profile.password-update');
    }
}
