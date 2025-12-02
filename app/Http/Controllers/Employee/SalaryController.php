<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $employee = $request->user()->employee;

        if (!$employee) {
            return redirect()->route('dashboard.index')->with('error', 'Employee data not found');
        }

        $salaries = Salary::where('karyawan_id', $employee->id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Hitung total gaji yang diterima
        $totalEarned = Salary::where('karyawan_id', $employee->id)
            ->sum('total_gaji');

        // Gaji bulan ini
        $currentMonth = now()->format('F Y');
        $currentMonthSalary = Salary::where('karyawan_id', $employee->id)
            ->where('bulan', $currentMonth)
            ->first();

        return view('pages.employee.salary', [
            'salaries' => $salaries,
            'employee' => $employee,
            'totalEarned' => $totalEarned,
            'currentMonthSalary' => $currentMonthSalary,
            'currentMonth' => $currentMonth
        ]);
    }
}
