<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\EmployeeLeaveBalance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = LeaveRequest::with('employee.user')
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $leaveRequests = $query->paginate(10);

        $statistics = [
            'pending' => LeaveRequest::where('status', 'pending')->count(),
            'approved' => LeaveRequest::where('status', 'approved')->count(),
            'rejected' => LeaveRequest::where('status', 'rejected')->count(),
            'cancelled' => LeaveRequest::where('status', 'cancelled')->count(),
        ];

        return view('pages.admin.leave-request', compact('leaveRequests', 'statistics', 'status'));
    }

    public function approve(Request $request, string $id)
    {
        $leaveRequest = LeaveRequest::with('employee')->findOrFail($id);

        if ($leaveRequest->status !== 'pending') {
            return back()->with('error', 'Only pending leave requests can be approved');
        }

        $leaveRequest->status = 'approved';
        $leaveRequest->save();

        for ($i = 0; $i < $leaveRequest->days_requested; $i++) {
            Attendance::updateOrCreate(
                [
                    'karyawan_id' => $leaveRequest->employee_id,
                    'tanggal' => Carbon::parse($leaveRequest->start_date)
                        ->addDays($i)
                        ->toDateString(),
                ],
                [
                    'status' => $leaveRequest->leave_type === 'sick' ? 'sakit' : 'izin',
                    'waktu_masuk' => null,
                    'waktu_keluar' => null,
                ]
            );
        }

        return back()->with('success', 'Leave request approved successfully');
    }

    public function reject(Request $request, string $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $leaveRequest = LeaveRequest::with('employee')->findOrFail($id);

        if ($leaveRequest->status !== 'pending') {
            return back()->with('error', 'Only pending leave requests can be rejected');
        }

        // Restore leave balance
        $leaveBalance = EmployeeLeaveBalance::where('employee_id', $leaveRequest->employee_id)->first();
        $balanceField = "{$leaveRequest->leave_type}_leave_balance";
        $leaveBalance->$balanceField += $leaveRequest->days_requested;
        $leaveBalance->save();

        $leaveRequest->status = 'rejected';
        $leaveRequest->rejection_reason = $validated['rejection_reason'] ?? null;
        $leaveRequest->save();

        return back()->with('success', 'Leave request rejected successfully');
    }
}
