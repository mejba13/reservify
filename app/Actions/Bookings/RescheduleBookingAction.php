<?php

namespace App\Actions\Bookings;

use App\Models\Booking;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Reschedule Booking Action
 *
 * Handles rescheduling a booking to a new time slot.
 */
class RescheduleBookingAction
{
    public function __construct(
        private AvailabilityService $availabilityService
    ) {}

    /**
     * Execute the action to reschedule a booking.
     *
     * @param Booking $booking
     * @param Carbon $newStartTime
     * @return Booking
     * @throws \Exception
     */
    public function execute(Booking $booking, Carbon $newStartTime): Booking
    {
        if (!$booking->canBeRescheduled()) {
            throw new \Exception('This booking cannot be rescheduled. It may be in the past or already cancelled.');
        }

        return DB::transaction(function () use ($booking, $newStartTime) {
            // Validate new time slot availability
            if (!$this->availabilityService->isTimeSlotAvailable($booking->provider, $booking->service, $newStartTime)) {
                throw new \Exception('The selected time slot is not available.');
            }

            // Calculate new end time
            $newEndTime = $newStartTime->copy()->addMinutes($booking->service->total_duration_minutes);

            // Update booking times
            $booking->update([
                'start_time' => $newStartTime,
                'end_time' => $newEndTime,
            ]);

            // TODO: Trigger notification

            return $booking->fresh();
        });
    }
}
