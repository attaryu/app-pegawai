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
        User::factory()->admin()->create([
            'role_id' => Role::factory()->admin()->create()->id,
        ]);

        $departmentNames = ['HR', 'Finance', 'IT', 'Marketing', 'R&D'];
        $departmentCount = count($departmentNames);

        $departments = Department::factory()
            ->sequence(...array_map(fn($name) => ['nama_departemen' => $name], $departmentNames))
            ->count($departmentCount)
            ->create();

        $positions = Position::factory()->count(10)->create();
        $employeeRole = Role::factory()->create();

        Employee::factory()
            ->count($departmentCount * rand(7, 13))
            ->sequence(fn() => [
                'departemen_id' => $departments->random()->id,
                'jabatan_id' => $positions->random()->id,
            ])
            ->create()
            ->each(function ($employee) use ($employeeRole) {
                if ($employee->status === 'aktif') {
                    $user = User::factory()
                        ->for($employeeRole)
                        ->create([
                            'email' => $employee->email,
                        ]);

                    $employee->user()->associate($user);
                    $employee->save();
                }

                Attendance::factory()
                    ->for($employee)
                    ->count(rand(10, max: 20))
                    ->create();

                Salary::factory()
                    ->for($employee)
                    ->count(rand(3, 12))
                    ->create([
                        'gaji_pokok' => $employee->position->gaji_pokok ?? 0,
                    ]);
            });
    }
}
