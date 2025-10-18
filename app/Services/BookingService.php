<?php

namespace App\Services;

use App\Models\HuntingBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingService
{
    public function createBooking(array $data): HuntingBooking
    {
        $guideId = $data['guide_id'];
        $date = $data['date'];

        $isBooked = HuntingBooking::query()
            ->where('guide_id', $guideId)
            ->whereDate('date', $date)
            ->exists();

        if ($isBooked) {
            throw ValidationException::withMessages([
                'date' => ['Selected guide is already booked for this date.'],
            ]);
        }

        return DB::transaction(static fn () => HuntingBooking::create($data));
    }
}
