<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['department', 'position'])->latest()->paginate(10);

        return view('pages.admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::select('id', 'nama_departemen')->get();
        $positions = Position::select('id', 'nama_jabatan')->get();

        return view('pages.admin.employees.create', compact('departments', 'positions'));
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
            'password' => 'string|min:6|nullable',
        ]);

        if ($request->status === 'aktif') {
            $role = Role::where('name', 'employee')->first();

            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password ?? env('EMPLOYEE_DEFAULT_PASSWORD')),
                'role_id' => $role->id,
            ]);

            $request->merge([
                'user_id' => $user->id,
            ]);
        }

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
            'user_id',
        ]));

        return redirect()->route('dashboard.admin.employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with(['department', 'position', 'attendance', 'salaries'])->find($id);

        return view('pages.admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::find($id);
        $departments = Department::select('id', 'nama_departemen')->get();
        $positions = Position::select('id', 'nama_jabatan')->get();

        return view('pages.admin.employees.edit', compact('employee', 'departments', 'positions'));
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
            'password' => 'string|min:6|nullable',
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

        if ($request->filled('password')) {
            $user = User::find($employee->user_id);

            if ($user) {
                $user->update([
                    'password' => Hash::make($request->password ?? env('EMPLOYEE_DEFAULT_PASSWORD')),
                ]);
            }
        }

        return redirect()->route('dashboard.admin.employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        $user = User::find($employee->user_id);

        if ($user) {
            $user->delete();
        }

        $employee->delete();

        return redirect()->route('dashboard.admin.employees.index');
    }
}
