<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'client_name' => ['required', 'string', 'max:255'],
            'client_phone' => [
                'required',
                'string',
                'regex:/^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/' //регулярка для проверки телефона юзера
            ],
            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    // Проверка что день не воскресенье
                    $date = Carbon::parse($value);
                    if ($date->isSunday()) {
                        $fail('Бронирование в воскресенье недоступно.');
                    }
                },
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    // Проверка что время в интервале 10:00-20:00
                    $time = Carbon::parse($value);
                    $startWorkTime = Carbon::parse('10:00');
                    $endWorkTime = Carbon::parse('20:00');
                    
                    if ($time->lessThan($startWorkTime) || $time->greaterThanOrEqualTo($endWorkTime)) {
                        $fail('Бронирование доступно только с 10:00 до 20:00.');
                    }
                },
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'service_id.required' => 'Необходимо выбрать услугу.',
            'service_id.exists' => 'Выбранная услуга не существует.',
            'client_name.required' => 'Пожалуйста, укажите ваше имя.',
            'client_name.max' => 'Имя не должно превышать 255 символов.',
            'client_phone.required' => 'Пожалуйста, укажите номер телефона.',
            'client_phone.regex' => 'Номер телефона должен быть в формате +7 (XXX) XXX-XX-XX.',
            'booking_date.required' => 'Необходимо выбрать дату бронирования.',
            'booking_date.after_or_equal' => 'Дата бронирования не может быть в прошлом.',
            'start_time.required' => 'Необходимо выбрать время начала.',
            'start_time.date_format' => 'Неверный формат времени.',
        ];
    }
}
