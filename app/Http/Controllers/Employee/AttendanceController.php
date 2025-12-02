<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
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
        $minCheckOutTime = $checkInTime->copy()->addHours(6);
        $maxCheckOutTime = $checkInTime->copy()->addHours(12);

        if (now()->greaterThan($maxCheckOutTime)) {
            return back()->with('error', 'Check out time exceeded (maximum 12 hours after check in)');
        }

        if (now()->lessThan($minCheckOutTime)) {
            return back()->with('error', 'You can check out only after 6 hours of check in');
        }

        // Update waktu keluar
        $todayAttendance->update([
            'waktu_keluar' => now()->format('H:i:s')
        ]);

        return back()->with('success', 'Check out successful');
    }
}
