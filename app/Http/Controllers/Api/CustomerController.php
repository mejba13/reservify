<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function profile(Request $request): JsonResponse
    {
        $customer = $request->user()->customer;
        
        if (!$customer) {
            return response()->json(['message' => 'Customer profile not found.'], 404);
        }

        return response()->json(['data' => new CustomerResource($customer)]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $customer = $request->user()->customer;
        
        if (!$customer) {
            return response()->json(['message' => 'Customer profile not found.'], 404);
        }

        $validated = $request->validate([
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'timezone' => ['nullable', 'string', 'max:50'],
        ]);

        $customer->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'data' => new CustomerResource($customer)
        ]);
    }

    public function bookings(Request $request): JsonResponse
    {
        $customer = $request->user()->customer;
        
        if (!$customer) {
            return response()->json(['message' => 'Customer profile not found.'], 404);
        }

        $bookings = $customer->bookings()
            ->with(['service', 'provider'])
            ->latest('start_time')
            ->get();

        return response()->json(['data' => BookingResource::collection($bookings)]);
    }

    public function notifications(Request $request): JsonResponse
    {
        return response()->json(['data' => [], 'message' => 'Notifications feature coming soon.']);
    }
}
