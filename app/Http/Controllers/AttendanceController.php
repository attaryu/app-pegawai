<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = Attendance::with('employee')->latest()->paginate(10);

        return view('attendances.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();

        return view('attendances.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,izin,sakit,alpha',
        ]);


        if ($request->status != 'hadir') {
            $request->merge([
                'waktu_masuk' => null,
                'waktu_keluar' => null,
            ]);
        }

        Attendance::create($request->only([
            'karyawan_id',
            'tanggal',
            'waktu_masuk',
            'waktu_keluar',
            'status',
        ]));

        return redirect()->route('attendances.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attendance = Attendance::find($id);
        $employees = Employee::all();

        return view('attendances.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        if ($request->status != 'hadir') {
            $request->merge([
                'waktu_masuk' => null,
                'waktu_keluar' => null,
            ]);
        }

        $attendance = Attendance::find($id);
        $attendance->update($request->only([
            'karyawan_id',
            'tanggal',
            'waktu_masuk',
            'waktu_keluar',
            'status',
        ]));

        return redirect()->route('attendances.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendance = Attendance::find($id);
        $attendance->delete();

        return redirect()->route('attendances.index');
    }
}
