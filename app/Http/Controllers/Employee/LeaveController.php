<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeLeaveBalance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $employee = $request->user()->employee;

        if (!$employee) {
            return redirect()->route('dashboard.index')->with('error', 'Employee data not found');
        }

        // Get or create leave balance
        $leaveBalance = EmployeeLeaveBalance::firstOrCreate(
            ['employee_id' => $employee->id],
            [
                'annual_leave_balance' => 12,
                'sick_leave_balance' => 8,
                'personal_leave_balance' => 5,
            ]
        );

        // Get leave requests
        $leaveRequests = LeaveRequest::where('employee_id', $employee->id)
            ->latest()
            ->take(10)
            ->get();


        $totalDaysUsed = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'approved')
            ->sum('days_requested');

        return view('pages.employee.leave.index', compact(
            'employee',
            'leaveBalance',
            'leaveRequests',
            'totalDaysUsed'
        ));
    }

    public function create(Request $request)
    {
        $employee = $request->user()->employee;

        if (!$employee) {
            return redirect()->route('dashboard.index')->with('error', 'Employee data not found');
        }

        // Get leave balance
        $leaveBalance = EmployeeLeaveBalance::firstOrCreate(
            ['employee_id' => $employee->id],
            [
                'annual_leave_balance' => 12,
                'sick_leave_balance' => 8,
                'personal_leave_balance' => 5,
            ]
        );

        return view('pages.employee.leave.request', compact('employee', 'leaveBalance'));
    }

    public function store(Request $request)
    {
        $employee = $request->user()->employee;

        if (!$employee) {
            return redirect()->route('dashboard.index')->with('error', 'Employee data not found');
        }

        $validated = $request->validate([
            'leave_type' => 'required|in:annual,sick,personal',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
        ]);

        // Calculate days requested
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $daysRequested = $startDate->diffInDays($endDate) + 1;

        // Check leave balance
        $leaveBalance = EmployeeLeaveBalance::where('employee_id', $employee->id)->first();

        $balanceField = $validated['leave_type'] . '_leave_balance';

        if ($leaveBalance->$balanceField < $daysRequested) {
            return back()->with('error', 'Insufficient leave balance for this request');
        }

        // Create leave request
        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type' => $validated['leave_type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'days_requested' => $daysRequested,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        // Deduct leave balance
        $leaveBalance->$balanceField -= $daysRequested;
        $leaveBalance->save();

        return redirect()->route('dashboard.employee.leave.index')
            ->with('success', 'Leave request submitted successfully');
    }
}
