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
        $status = fake()->randomElement(['hadir', 'izin', 'sakit', 'alpha']);

        if ($status === 'hadir') {
            $masuk = fake()->dateTimeBetween('07:00:00', '09:30:00');
            $keluar = fake()->dateTimeBetween('16:00:00', '18:00:00');

            return [
                'tanggal' => fake()->dateTimeBetween('-2 year'),
                'status' => $status,
                'waktu_masuk' => $masuk->format('H:i'),
                'waktu_keluar' => $keluar->format('H:i'),
            ];
        }

        return [
            'tanggal' => fake()->dateTimeBetween('-2 year'),
            'status' => $status,
            'waktu_masuk' => null,
            'waktu_keluar' => null,
        ];
    }
}
