<?php

namespace App\Actions\Bookings;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Provider;
use App\Models\Service;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Create Booking Action
 *
 * Encapsulates the logic for creating a new booking with validation.
 */
class CreateBookingAction
{
    public function __construct(
        private AvailabilityService $availabilityService
    ) {}

    /**
     * Execute the action to create a booking.
     *
     * @param Customer $customer
     * @param Service $service
     * @param Provider $provider
     * @param Carbon $startTime
     * @param string|null $notes
     * @return Booking
     * @throws \Exception
     */
    public function execute(
        Customer $customer,
        Service $service,
        Provider $provider,
        Carbon $startTime,
        ?string $notes = null
    ): Booking {
        return DB::transaction(function () use ($customer, $service, $provider, $startTime, $notes) {
            // Validate availability
            if (!$this->availabilityService->isTimeSlotAvailable($provider, $service, $startTime)) {
                throw new \Exception('The selected time slot is no longer available.');
            }

            // Calculate end time
            $endTime = $startTime->copy()->addMinutes($service->total_duration_minutes);

            // Create the booking
            return Booking::create([
                'customer_id' => $customer->id,
                'provider_id' => $provider->id,
                'service_id' => $service->id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => 'pending',
                'notes' => $notes,
            ]);
        });
    }
}
