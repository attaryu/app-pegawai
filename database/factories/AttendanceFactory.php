<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Tanpa 'izin' karena itu untuk leave request
        $status = fake()->randomElement(['present', 'alpha']);

        if ($status === 'present') {
            $masuk = fake()->dateTimeBetween('07:00:00', '09:30:00');
            $keluar = fake()->dateTimeBetween('16:00:00', '18:00:00');

            return [
                'tanggal' => fake()->dateTimeBetween('-1 year', 'now'),
                'status' => $status,
                'waktu_masuk' => $masuk->format('H:i'),
                'waktu_keluar' => $keluar->format('H:i'),
            ];
        }

        return [
            'tanggal' => fake()->dateTimeBetween('-1 year', 'now'),
            'status' => $status,
            'waktu_masuk' => null,
            'waktu_keluar' => null,
        ];
    }
}
