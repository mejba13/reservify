<?php

namespace App\Actions\Bookings;

use App\Models\Booking;

/**
 * Cancel Booking Action
 *
 * Handles the cancellation of a booking with validation.
 */
class CancelBookingAction
{
    /**
     * Execute the action to cancel a booking.
     *
     * @param Booking $booking
     * @param string $reason
     * @return Booking
     * @throws \Exception
     */
    public function execute(Booking $booking, string $reason): Booking
    {
        if (!$booking->canBeCancelled()) {
            throw new \Exception('This booking cannot be cancelled. It may be in the past or already cancelled.');
        }

        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
            'cancelled_at' => now(),
        ]);

        // TODO: Trigger notification
        // TODO: Process refund if applicable

        return $booking->fresh();
    }
}
