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

        $currentMonth = now()->format('F');
        $monthMap = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];
        $currentMonthIndo = $monthMap[$currentMonth];

        Employee::factory()
            ->count($departmentCount * rand(10, 20))
            ->sequence(fn() => [
                'departemen_id' => $departments->random()->id,
                'jabatan_id' => $positions->random()->id,
            ])
            ->create()
            ->each(function ($employee) use ($employeeRole, $currentMonthIndo) {
                if ($employee->status === 'aktif') {
                    $user = User::factory()
                        ->for($employeeRole)
                        ->create([
                            'email' => $employee->email,
                        ]);

                    $employee->user()->associate($user);
                    $employee->save();
                }

                // Generate attendance for the current week (Monday to Sunday)
                $startOfWeek = now()->startOfWeek();
                for ($i = 0; $i < 7; $i++) {
                    $date = $startOfWeek->copy()->addDays($i);
                    
                    // 90% chance of attendance
                    if (rand(1, 100) <= 90) {
                        $status = fake()->randomElement(['hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'izin', 'sakit']);
                        
                        Attendance::create([
                            'karyawan_id' => $employee->id,
                            'tanggal' => $date->format('Y-m-d'),
                            'status' => $status,
                            'waktu_masuk' => $status === 'hadir' ? fake()->time('H:i', '09:30') : null,
                            'waktu_keluar' => $status === 'hadir' ? fake()->time('H:i', '18:00') : null,
                        ]);
                    }
                }

                // Generate today's attendance (for demonstration)
                if (rand(1, 100) <= 85) {
                    $todayStatus = fake()->randomElement(['hadir', 'hadir', 'hadir', 'hadir', 'izin', 'sakit']);
                    Attendance::create([
                        'karyawan_id' => $employee->id,
                        'tanggal' => now()->format('Y-m-d'),
                        'status' => $todayStatus,
                        'waktu_masuk' => $todayStatus === 'hadir' ? fake()->time('H:i', '09:30') : null,
                        'waktu_keluar' => $todayStatus === 'hadir' ? fake()->time('H:i', '18:00') : null,
                    ]);
                }

                // Generate past attendance (random)
                Attendance::factory()
                    ->for($employee)
                    ->count(rand(30, 60))
                    ->create();

                // Generate salary for current month (for demonstration)
                Salary::factory()
                    ->for($employee)
                    ->create([
                        'bulan' => $currentMonthIndo,
                        'gaji_pokok' => $employee->position->gaji_pokok ?? 0,
                    ]);

                // Generate past salaries (random)
                $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $pastMonths = array_diff($months, [$currentMonthIndo]);
                
                foreach (fake()->randomElements($pastMonths, rand(3, 8)) as $month) {
                    Salary::factory()
                        ->for($employee)
                        ->create([
                            'bulan' => $month,
                            'gaji_pokok' => $employee->position->gaji_pokok ?? 0,
                        ]);
                }
            });
    }
}
