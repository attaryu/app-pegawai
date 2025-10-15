<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Salary;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $departmentNames = ['HR', 'Finance', 'IT', 'Marketing', 'R&D'];
        $departmentCount = count($departmentNames);

        $departments = Department::factory()
            ->sequence(...array_map(fn($name) => ['nama_departemen' => $name], $departmentNames))
            ->count(count($departmentNames))
            ->create();

        $positions = Position::factory()->count(10)->create();

        Employee::factory()
            ->count($departmentCount * rand(10, 20))
            ->sequence(fn() => [
                'departemen_id' => $departments->random()->id,
                'jabatan_id' => $positions->random()->id,
            ])
            ->create()
            ->each(function ($employee) {
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
