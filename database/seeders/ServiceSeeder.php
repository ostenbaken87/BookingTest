<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Поездка на квадроцикле',
                'duration_minutes' => 30,
            ],
            [
                'name' => 'Поездка на квадроцикле',
                'duration_minutes' => 60,
            ],
            [
                'name' => 'Тур на эндуро',
                'duration_minutes' => 60,
            ],
            [
                'name' => 'Тур на эндуро',
                'duration_minutes' => 120,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
