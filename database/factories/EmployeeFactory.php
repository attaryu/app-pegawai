<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_lengkap' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'nomor_telepon' => fake()->phoneNumber(),
            'tanggal_lahir' => fake()->dateTimeBetween('-40 years', '-18 years'),
            'alamat' => fake()->address(),
            'tanggal_masuk' => fake()->dateTimeBetween('-5 years'),
            'status' => fake()->randomElement(['aktif', 'nonaktif']),
        ];
    }
}
