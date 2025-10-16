<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Booking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'client_name',
        'client_phone',
        'booking_date',
        'start_time',
        'end_time',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeForDate(Builder $query, $date): Builder
    {
        return $query->whereDate('booking_date', $date);
    }

    public function scopeForService(Builder $query, $serviceId): Builder
    {
        return $query->where('service_id', $serviceId);
    }

    public function overlaps(string $startTime, string $endTime): bool
    {
        $bookingStart = Carbon::parse($this->start_time);
        $bookingEnd = Carbon::parse($this->end_time);
        $newStart = Carbon::parse($startTime);
        $newEnd = Carbon::parse($endTime);

        return $bookingStart->lessThan($newEnd) && $bookingEnd->greaterThan($newStart);
    }
}
