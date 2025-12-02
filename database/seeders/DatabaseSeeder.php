<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->admin()->create([
            'role_id' => Role::factory()->admin()->create()->id,
        ]);

        // Create departments
        $departmentNames = ['HR', 'IT', 'Finance'];
        $departments = Department::factory()
            ->sequence(...array_map(fn($name) => ['nama_departemen' => $name], $departmentNames))
            ->count(count($departmentNames))
            ->create();

        // Create positions
        $positions = Position::factory()->count(6)->create();

        // Create employee role
        $employeeRole = Role::factory()->create();

        // Create employees (15-20 employees)
        $employees = Employee::factory()
            ->count(rand(15, 20))
            ->sequence(fn() => [
                'departemen_id' => $departments->random()->id,
                'jabatan_id' => $positions->random()->id,
            ])
            ->create()
            ->each(function ($employee) use ($employeeRole) {
                // Create user for active employees only
                if ($employee->status === 'aktif') {
                    $user = User::factory()
                        ->for($employeeRole)
                        ->create([
                            'email' => $employee->email,
                        ]);

                    $employee->user()->associate($user);
                    $employee->save();
                }
            });

        // Create attendance records for each employee (last 6 months)
        $employees->each(function ($employee) {
            // Generate 50-80 attendance records per employee
            Attendance::factory()
                ->count(rand(30, 50))
                ->create([
                    'karyawan_id' => $employee->id,
                ]);
        });

        // Create salary records for each employee (last 6-12 months)
        $currentMonth = now()->month;

        $employees->each(function ($employee) {
            $position = $employee->position;

            // Generate salary untuk beberapa bulan terakhir
            for ($i = 11; $i >= 0; $i--) {
                Salary::factory()->create([
                    'karyawan_id' => $employee->id,
                    'gaji_pokok' => $position->gaji_pokok,
                ]);
            }
        });
    }
}
