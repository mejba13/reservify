<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Provider;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Booking Service
 *
 * Handles booking business logic and orchestration.
 */
class BookingService
{
    public function __construct(
        private AvailabilityService $availabilityService
    ) {}

    /**
     * Create a new booking.
     *
     * @param Customer $customer
     * @param array $data
     * @return Booking
     * @throws \Exception
     */
    public function createBooking(Customer $customer, array $data): Booking
    {
        return DB::transaction(function () use ($customer, $data) {
            $service = Service::findOrFail($data['service_id']);
            $provider = Provider::findOrFail($data['provider_id']);
            $startTime = Carbon::parse($data['start_time']);

            // Validate that time slot is available
            if (!$this->availabilityService->isTimeSlotAvailable($provider, $service, $startTime)) {
                throw new \Exception('The selected time slot is no longer available.');
            }

            // Calculate end time
            $endTime = $startTime->copy()->addMinutes($service->total_duration_minutes);

            // Create booking
            $booking = Booking::create([
                'customer_id' => $customer->id,
                'provider_id' => $provider->id,
                'service_id' => $service->id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
            ]);

            // TODO: Send confirmation notification
            // TODO: Handle payment if required

            return $booking;
        });
    }

    /**
     * Cancel a booking.
     *
     * @param Booking $booking
     * @param string $reason
     * @return Booking
     * @throws \Exception
     */
    public function cancelBooking(Booking $booking, string $reason): Booking
    {
        if (!$booking->canBeCancelled()) {
            throw new \Exception('This booking cannot be cancelled.');
        }

        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
            'cancelled_at' => now(),
        ]);

        // TODO: Send cancellation notification
        // TODO: Process refund if payment was made

        return $booking->fresh();
    }

    /**
     * Reschedule a booking to a new time.
     *
     * @param Booking $booking
     * @param Carbon $newStartTime
     * @return Booking
     * @throws \Exception
     */
    public function rescheduleBooking(Booking $booking, Carbon $newStartTime): Booking
    {
        if (!$booking->canBeRescheduled()) {
            throw new \Exception('This booking cannot be rescheduled.');
        }

        return DB::transaction(function () use ($booking, $newStartTime) {
            $service = $booking->service;
            $provider = $booking->provider;

            // Validate new time slot is available
            if (!$this->availabilityService->isTimeSlotAvailable($provider, $service, $newStartTime)) {
                throw new \Exception('The selected time slot is not available.');
            }

            // Calculate new end time
            $newEndTime = $newStartTime->copy()->addMinutes($service->total_duration_minutes);

            // Update booking
            $booking->update([
                'start_time' => $newStartTime,
                'end_time' => $newEndTime,
            ]);

            // TODO: Send reschedule notification

            return $booking->fresh();
        });
    }
}
