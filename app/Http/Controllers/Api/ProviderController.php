<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function dashboard(Request $request): JsonResponse
    {
        $provider = $request->user()->provider;
        
        if (!$provider) {
            return response()->json(['message' => 'Provider profile not found.'], 404);
        }

        $todayBookings = $provider->todaysBookings;
        $upcomingBookings = $provider->upcomingBookings()->take(10)->get();

        return response()->json([
            'provider' => [
                'id' => $provider->id,
                'name' => $provider->name,
                'is_active' => $provider->is_active,
            ],
            'stats' => [
                'today_bookings' => $todayBookings->count(),
                'upcoming_bookings' => $upcomingBookings->count(),
            ],
            'today_bookings' => $todayBookings,
            'upcoming_bookings' => $upcomingBookings,
        ]);
    }

    public function analytics(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Analytics feature coming soon.',
            'data' => [],
        ]);
    }

    public function revenue(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Revenue tracking coming soon.',
            'data' => [],
        ]);
    }
}
