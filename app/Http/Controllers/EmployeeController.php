<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['department', 'position'])->latest()->paginate(10);

        return view('pages.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::select('id', 'nama_departemen')->get();
        $positions = Position::select('id', 'nama_jabatan')->get();

        return view('pages.employees.create', compact('departments', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|string|max:50',
            'departemen_id' => 'required|exists:departments,id',
            'jabatan_id' => 'required|exists:positions,id',
        ]);

        Employee::create($request->only([
            'nama_lengkap',
            'email',
            'nomor_telepon',
            'tanggal_lahir',
            'alamat',
            'tanggal_masuk',
            'status',
            'departemen_id',
            'jabatan_id',
        ]));

        return redirect()->route('dashboard.admin.employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with(['department', 'position', 'attendance', 'salaries'])->find($id);

        return view('pages.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::find($id);
        $departments = Department::select('id', 'nama_departemen')->get();
        $positions = Position::select('id', 'nama_jabatan')->get();

        return view('pages.employees.edit', compact('employee', 'departments', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|string|max:50',
            'departemen_id' => 'required|exists:departments,id',
            'jabatan_id' => 'required|exists:positions,id',
        ]);

        $employee = Employee::find($id);
        $employee->update($request->only([
            'nama_lengkap',
            'email',
            'nomor_telepon',
            'tanggal_lahir',
            'alamat',
            'tanggal_masuk',
            'status',
            'departemen_id',
            'jabatan_id',
        ]));

        return redirect()->route('dashboard.admin.employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        $employee->delete();

        return redirect()->route('dashboard.admin.employees.index');
    }

    public function statistic()
    {
        $employee = Auth::user()->employee;

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
}
