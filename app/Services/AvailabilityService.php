<?php

namespace App\Services;

use App\Models\AvailabilityException;
use App\Models\AvailabilityTemplate;
use App\Models\Booking;
use App\Models\Provider;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Availability Service
 *
 * Handles complex availability calculations and time slot generation.
 */
class AvailabilityService
{
    /**
     * Get available time slots for a provider on a specific date.
     *
     * @param Provider $provider
     * @param Service $service
     * @param Carbon $date
     * @return Collection
     */
    public function getAvailableTimeSlots(Provider $provider, Service $service, Carbon $date): Collection
    {
        // Get provider's availability template for this day of week
        $dayOfWeek = $date->dayOfWeek;
        $templates = $provider->availabilityTemplates()->forDay($dayOfWeek)->get();

        if ($templates->isEmpty()) {
            return collect();
        }

        // Check for exceptions on this date
        $exceptions = $provider->availabilityExceptions()
            ->forDate($date)
            ->get();

        // If provider is completely unavailable on this date
        if ($exceptions->where('is_unavailable', true)->where('start_time', null)->isNotEmpty()) {
            return collect();
        }

        // Get existing bookings for this date
        $existingBookings = $provider->bookings()
            ->whereDate('start_time', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $availableSlots = collect();
        $slotDuration = $service->total_duration_minutes;

        foreach ($templates as $template) {
            $startTime = Carbon::parse($date->format('Y-m-d') . ' ' . $template->start_time);
            $endTime = Carbon::parse($date->format('Y-m-d') . ' ' . $template->end_time);

            // Generate slots for this time block
            $currentSlot = $startTime->copy();

            while ($currentSlot->copy()->addMinutes($slotDuration) <= $endTime) {
                $slotEnd = $currentSlot->copy()->addMinutes($slotDuration);

                // Check if slot is in the past
                if ($currentSlot < now()) {
                    $currentSlot = $slotEnd;
                    continue;
                }

                // Check if slot conflicts with existing bookings
                $hasConflict = $this->checkSlotConflict($currentSlot, $slotEnd, $existingBookings);

                // Check if slot conflicts with exceptions
                $hasException = $this->checkSlotException($currentSlot, $slotEnd, $exceptions);

                if (!$hasConflict && !$hasException) {
                    $availableSlots->push([
                        'start_time' => $currentSlot->toIso8601String(),
                        'end_time' => $slotEnd->toIso8601String(),
                        'available' => true,
                    ]);
                }

                $currentSlot = $slotEnd;
            }
        }

        return $availableSlots;
    }

    /**
     * Check if a time slot conflicts with existing bookings.
     */
    private function checkSlotConflict(Carbon $slotStart, Carbon $slotEnd, Collection $bookings): bool
    {
        return $bookings->contains(function ($booking) use ($slotStart, $slotEnd) {
            return $slotStart < $booking->end_time && $slotEnd > $booking->start_time;
        });
    }

    /**
     * Check if a time slot conflicts with availability exceptions.
     */
    private function checkSlotException(Carbon $slotStart, Carbon $slotEnd, Collection $exceptions): bool
    {
        return $exceptions->contains(function ($exception) use ($slotStart, $slotEnd) {
            if (!$exception->is_unavailable) {
                return false;
            }

            // If exception has no time, it blocks the entire day
            if (!$exception->start_time || !$exception->end_time) {
                return true;
            }

            $exceptionStart = Carbon::parse($exception->date->format('Y-m-d') . ' ' . $exception->start_time);
            $exceptionEnd = Carbon::parse($exception->date->format('Y-m-d') . ' ' . $exception->end_time);

            return $slotStart < $exceptionEnd && $slotEnd > $exceptionStart;
        });
    }

    /**
     * Check if a specific time slot is available.
     */
    public function isTimeSlotAvailable(Provider $provider, Service $service, Carbon $startTime): bool
    {
        $endTime = $startTime->copy()->addMinutes($service->total_duration_minutes);

        // Check existing bookings
        $hasConflict = $provider->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
                });
            })
            ->exists();

        return !$hasConflict;
    }
}
