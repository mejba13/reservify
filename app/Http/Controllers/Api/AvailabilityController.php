<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\Service;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function __construct(private AvailabilityService $availabilityService) {}

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'provider_id' => ['required', 'exists:providers,id'],
            'service_id' => ['required', 'exists:services,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $provider = Provider::findOrFail($validated['provider_id']);
        $service = Service::findOrFail($validated['service_id']);
        $date = Carbon::parse($validated['date']);

        $slots = $this->availabilityService->getAvailableTimeSlots($provider, $service, $date);

        return response()->json([
            'provider' => [
                'id' => $provider->id,
                'name' => $provider->name,
            ],
            'service' => [
                'id' => $service->id,
                'name' => $service->name,
                'duration_minutes' => $service->duration_minutes,
            ],
            'date' => $date->toDateString(),
            'available_slots' => $slots,
        ]);
    }

    public function show(Request $request, Provider $provider): JsonResponse
    {
        $templates = $provider->availabilityTemplates;
        $exceptions = $provider->availabilityExceptions()->where('date', '>=', now())->get();

        return response()->json([
            'provider' => [
                'id' => $provider->id,
                'name' => $provider->name,
            ],
            'templates' => $templates,
            'exceptions' => $exceptions,
        ]);
    }
}
