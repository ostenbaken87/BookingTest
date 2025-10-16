<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    /**
     * @var BookingService
     */
    private BookingService $bookingService;

    /**
     * Constructor
     *
     * @param BookingService $bookingService
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Получить доступные слоты для бронирования
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAvailableSlots(Request $request): JsonResponse
    {
        $request->validate([
            'service_id' => 'required|integer|exists:services,id',
            'date' => 'required|date',
        ]);

        $slots = $this->bookingService->getAvailableSlots(
            $request->input('service_id'),
            $request->input('date')
        );

        return response()->json([
            'success' => true,
            'data' => $slots,
        ]);
    }

    /**
     * Создать новое бронирование
     *
     * @param BookingRequest $request
     * @return JsonResponse
     */
    public function store(BookingRequest $request): JsonResponse
    {
        try {
            $booking = $this->bookingService->createBooking($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Бронирование успешно создано!',
                'data' => new BookingResource($booking),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
