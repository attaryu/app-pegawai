<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Salary>
 */
class SalaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bulan' => fake()->randomElement(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']),
            'gaji_pokok' => 0,
            'gaji_tunjangan' => fake()->numberBetween(1000000, 5000000),
            'potongan' => fake()->numberBetween(100000, 3000000),
            'total_gaji' => 0,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Salary $salary) {
            $salary->update([
                'total_gaji' => $salary->gaji_pokok + $salary->gaji_tunjangan - $salary->potongan,
            ]);
        });
    }
}
