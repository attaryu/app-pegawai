<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salaries = Salary::with('employee')->get();

        return view('salaries.index', compact('salaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::with('position')->get();

        return view('salaries.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'bulan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
            'gaji_tunjangan' => 'required|numeric|min:0',
            'potongan' => 'required|numeric|min:0',
        ]);

        $request->merge([
            'total_gaji' => $request->gaji_pokok + $request->gaji_tunjangan - $request->potongan,
        ]);

        Salary::create($request->only([
            'karyawan_id',
            'bulan',
            'gaji_pokok',
            'gaji_tunjangan',
            'potongan',
            'total_gaji',
        ]));

        return redirect()->route('salaries.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salary $salary)
    {
        $employees = Employee::with('position')->get();
        $salary = Salary::with('employee')->find($salary->id);

        return view('salaries.edit', compact('salary', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salary $salary)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'bulan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
            'gaji_tunjangan' => 'required|numeric|min:0',
            'potongan' => 'required|numeric|min:0',
        ]);

        $request->merge([
            'total_gaji' => $request->gaji_pokok + ($request->gaji_tunjangan ?? 0) - ($request->potongan ?? 0),
        ]);

        $salary->update($request->only([
            'karyawan_id',
            'bulan',
            'gaji_pokok',
            'gaji_tunjangan',
            'potongan',
            'total_gaji',
        ]));

        return redirect()->route('salaries.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        
    }
}
