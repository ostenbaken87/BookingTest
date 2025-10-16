<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Booking;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quadBike30 = Service::where('name', 'Поездка на квадроцикле')
            ->where('duration_minutes', 30)
            ->first();
            
        $quadBike60 = Service::where('name', 'Поездка на квадроцикле')
            ->where('duration_minutes', 60)
            ->first();
            
        $enduro60 = Service::where('name', 'Тур на эндуро')
            ->where('duration_minutes', 60)
            ->first();
            
        $enduro120 = Service::where('name', 'Тур на эндуро')
            ->where('duration_minutes', 120)
            ->first();

        $bookings = [
            [
                'service_id' => $quadBike30->id,
                'client_name' => 'Иван Иванов',
                'client_phone' => '+7 (900) 123-45-67',
                'booking_date' => '2025-10-16',
                'start_time' => '13:00',
                'end_time' => '14:00',
                'status' => 'active',
            ],
            [
                'service_id' => $quadBike30->id,
                'client_name' => 'Петр Петров',
                'client_phone' => '+7 (900) 234-56-78',
                'booking_date' => '2025-10-16',
                'start_time' => '16:00',
                'end_time' => '17:00',
                'status' => 'active',
            ],
            [
                'service_id' => $quadBike30->id,
                'client_name' => 'Сидор Сидоров',
                'client_phone' => '+7 (900) 345-67-89',
                'booking_date' => '2025-10-17',
                'start_time' => '10:00',
                'end_time' => '11:00',
                'status' => 'active',
            ],
            [
                'service_id' => $quadBike30->id,
                'client_name' => 'Алексей Алексеев',
                'client_phone' => '+7 (900) 456-78-90',
                'booking_date' => '2025-10-17',
                'start_time' => '11:00',
                'end_time' => '12:00',
                'status' => 'active',
            ],
            [
                'service_id' => $quadBike30->id,
                'client_name' => 'Дмитрий Дмитриев',
                'client_phone' => '+7 (900) 567-89-01',
                'booking_date' => '2025-10-17',
                'start_time' => '13:00',
                'end_time' => '14:00',
                'status' => 'active',
            ],
            [
                'service_id' => $quadBike30->id,
                'client_name' => 'Николай Николаев',
                'client_phone' => '+7 (900) 678-90-12',
                'booking_date' => '2025-10-17',
                'start_time' => '18:00',
                'end_time' => '19:00',
                'status' => 'active',
            ],
            [
                'service_id' => $quadBike60->id,
                'client_name' => 'Михаил Михайлов',
                'client_phone' => '+7 (900) 789-01-23',
                'booking_date' => '2025-10-16',
                'start_time' => '10:00',
                'end_time' => '11:30',
                'status' => 'active',
            ],
            [
                'service_id' => $enduro60->id,
                'client_name' => 'Андрей Андреев',
                'client_phone' => '+7 (900) 890-12-34',
                'booking_date' => '2025-10-16',
                'start_time' => '10:00',
                'end_time' => '11:30',
                'status' => 'active',
            ],
            [
                'service_id' => $enduro60->id,
                'client_name' => 'Сергей Сергеев',
                'client_phone' => '+7 (900) 901-23-45',
                'booking_date' => '2025-10-16',
                'start_time' => '11:30',
                'end_time' => '13:00',
                'status' => 'active',
            ],
            [
                'service_id' => $enduro60->id,
                'client_name' => 'Владимир Владимиров',
                'client_phone' => '+7 (900) 012-34-56',
                'booking_date' => '2025-10-16',
                'start_time' => '18:30',
                'end_time' => '20:00',
                'status' => 'active',
            ],
            [
                'service_id' => $enduro120->id,
                'client_name' => 'Олег Олегов',
                'client_phone' => '+7 (900) 123-45-60',
                'booking_date' => '2025-10-17',
                'start_time' => '14:00',
                'end_time' => '16:30',
                'status' => 'active',
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }
    }
}
