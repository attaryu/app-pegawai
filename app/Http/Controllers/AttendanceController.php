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

        return view('pages.attendances.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();

        return view('pages.attendances.create', compact('employees'));
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

        return redirect()->route('dashboard.admin.attendances.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attendance = Attendance::find($id);
        $employees = Employee::all();

        return view('pages.attendances.edit', compact('attendance', 'employees'));
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

        return redirect()->route('dashboard.admin.attendances.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendance = Attendance::find($id);
        $attendance->delete();

        return redirect()->route('dashboard.admin.attendances.index');
    }

    public function history(Request $request)
    {
        $employee = $request->user()->employee;

        if (!$employee) {
            return back()->with('error', 'Employee data not found');
        }

        $attendances = Attendance::where('karyawan_id', $employee->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('pages.employee.attendance.history', [
            'attendances' => $attendances,
            'employee' => $employee,
        ]);
    }

    /**
     * Employee check in
     */
    public function checkIn(Request $request)
    {
        $employee = $request->user()->employee;

        if (!$employee) {
            return back()->with('error', 'Employee data not found');
        }

        // Validasi waktu (7-9 pagi, hari kerja)
        $currentHour = now()->hour;
        $isWeekday = now()->isWeekday();

        if (!$isWeekday) {
            return back()->with('error', 'Check in only available on weekdays');
        }

        if ($currentHour < 7 || $currentHour >= 9) {
            return back()->with('error', 'Check in only available from 7:00 AM to 9:00 AM');
        }

        // Cek apakah sudah check in hari ini
        $todayAttendance = Attendance::where('karyawan_id', $employee->id)
            ->whereDate('tanggal', today())
            ->first();

        if ($todayAttendance) {
            return back()->with('error', 'You have already checked in today');
        }

        // Buat record attendance
        Attendance::create([
            'karyawan_id' => $employee->id,
            'tanggal' => today(),
            'waktu_masuk' => now()->format('H:i:s'),
            'waktu_keluar' => null,
            'status' => 'present'
        ]);

        return back()->with('success', 'Check in successful');
    }

    /**
     * Employee check out
     */
    public function checkOut(Request $request)
    {
        $employee = $request->user()->employee;

        if (!$employee) {
            return back()->with('error', 'Employee data not found');
        }

        // Cek attendance hari ini
        $todayAttendance = Attendance::where('karyawan_id', $employee->id)
            ->whereDate('tanggal', today())
            ->first();

        if (!$todayAttendance) {
            return back()->with('error', 'Please check in first');
        }

        if ($todayAttendance->waktu_keluar) {
            return back()->with('error', 'You have already checked out today');
        }

        // Validasi maksimal 12 jam setelah check in
        $checkInTime = \Carbon\Carbon::parse($todayAttendance->tanggal . ' ' . $todayAttendance->waktu_masuk);
        $maxCheckOutTime = $checkInTime->copy()->addHours(12);

        if (now()->greaterThan($maxCheckOutTime)) {
            return back()->with('error', 'Check out time exceeded (maximum 12 hours after check in)');
        }

        // Update waktu keluar
        $todayAttendance->update([
            'waktu_keluar' => now()->format('H:i:s')
        ]);

        return back()->with('success', 'Check out successful');
    }
}
