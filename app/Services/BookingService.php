<?php

namespace App\Services;

use App\Models\Service;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class BookingService
{
     //Начало рабочего дня (МСК)

    const WORK_START_HOUR = 10;

     //Конец рабочего дня (МСК)
    const WORK_END_HOUR = 20;

     //Дополнительное время после услуги (минуты)
    const ADDITIONAL_TIME = 30;

     //Интервал между слотами (минуты)
    const SLOT_INTERVAL = 30;

     //Получить доступные слоты для услуги на определенную дату
    public function getAvailableSlots(int $serviceId, string $date): Collection
    {
        $service = Service::findOrFail($serviceId);
        $bookingDate = Carbon::parse($date);

        if ($bookingDate->isSunday()) {
            return collect([]);
        }

        $existingBookings = Booking::active()
            ->forService($serviceId)
            ->forDate($date)
            ->orderBy('start_time')
            ->get();

        $allSlots = $this->generateTimeSlots($service->duration_minutes);

        $availableSlots = $allSlots->filter(function ($slot) use ($existingBookings, $service) {
            $slotStart = $slot['start_time'];
            $slotEnd = $this->calculateEndTime($slotStart, $service->duration_minutes);

            foreach ($existingBookings as $booking) {
                if ($this->timeSlotsOverlap($slotStart, $slotEnd, $booking->start_time, $booking->end_time)) {
                    return false;
                }
            }

            return true;
        });

        return $availableSlots->values();
    }

     //Проверить доступность слота для бронирования
    public function checkAvailability(int $serviceId, string $date, string $startTime): bool
    {
        $service = Service::findOrFail($serviceId);
        $endTime = $this->calculateEndTime($startTime, $service->duration_minutes);

        // Проверяем пересечение с активными бронированиями
        $overlappingBookings = Booking::active()
            ->forService($serviceId)
            ->forDate($date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<=', $startTime)
                      ->where('end_time', '>', $startTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                      ->where('end_time', '>=', $endTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '>=', $startTime)
                      ->where('end_time', '<=', $endTime);
                });
            })
            ->exists();

        return !$overlappingBookings;
    }

     //Создать новое бронирование c учтом race condition
    public function createBooking(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $service = Service::lockForUpdate()->findOrFail($data['service_id']);

            // Рассчитываем время окончания
            $endTime = $this->calculateEndTime($data['start_time'], $service->duration_minutes);

            // Дополнительная проверка доступности внутри транзакции
            if (!$this->checkAvailability($data['service_id'], $data['booking_date'], $data['start_time'])) {
                throw new \Exception('Выбранное время уже забронировано. Пожалуйста, выберите другое время.');
            }

            // Создаем бронирование
            $booking = Booking::create([
                'service_id' => $data['service_id'],
                'client_name' => $data['client_name'],
                'client_phone' => $data['client_phone'],
                'booking_date' => $data['booking_date'],
                'start_time' => $data['start_time'],
                'end_time' => $endTime,
                'status' => 'active',
            ]);

            return $booking->load('service');
        });
    }

    /**
     * Рассчитать время окончания бронирования
     *
     * @param string $startTime
     * @param int $durationMinutes
     * @return string
     */
    public function calculateEndTime(string $startTime, int $durationMinutes): string
    {
        $start = Carbon::parse($startTime);
        $totalDuration = $durationMinutes + self::ADDITIONAL_TIME;
        
        return $start->addMinutes($totalDuration)->format('H:i');
    }

    /**
     * Генерировать все временные слоты для дня
     *
     * @param int $serviceDuration
     * @return Collection
     */
    private function generateTimeSlots(int $serviceDuration): Collection
    {
        $slots = collect([]);
        $currentTime = Carbon::today()->setHour(self::WORK_START_HOUR)->setMinute(0);
        $endTime = Carbon::today()->setHour(self::WORK_END_HOUR)->setMinute(0);
        
        $totalDuration = $serviceDuration + self::ADDITIONAL_TIME;

        while ($currentTime->copy()->addMinutes($totalDuration)->lessThanOrEqualTo($endTime)) {
            $slotEnd = $this->calculateEndTime($currentTime->format('H:i'), $serviceDuration);
            
            $slots->push([
                'start_time' => $currentTime->format('H:i'),
                'end_time' => $slotEnd,
                'display' => $currentTime->format('H:i'),
            ]);

            $currentTime->addMinutes(self::SLOT_INTERVAL);
        }

        return $slots;
    }

    /**
     * Проверить пересечение временных слотов
     *
     * @param string $start1
     * @param string $end1
     * @param string $start2
     * @param string $end2
     * @return bool
     */
    private function timeSlotsOverlap(string $start1, string $end1, string $start2, string $end2): bool
    {
        $slot1Start = Carbon::parse($start1);
        $slot1End = Carbon::parse($end1);
        $slot2Start = Carbon::parse($start2);
        $slot2End = Carbon::parse($end2);

        return $slot1Start->lessThan($slot2End) && $slot1End->greaterThan($slot2Start);
    }
}

