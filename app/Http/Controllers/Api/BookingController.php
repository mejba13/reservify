<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CancelBookingRequest;
use App\Http\Requests\Api\CreateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    public function index(Request $request): JsonResponse
    {
        $customer = $request->user()->customer;
        if (!$customer) {
            return response()->json(['message' => 'Customer profile not found.'], 404);
        }

        $bookings = $customer->bookings()->with(['service', 'provider'])->latest('start_time')->paginate(15);

        return response()->json([
            'data' => BookingResource::collection($bookings->items()),
            'meta' => [
                'current_page' => $bookings->currentPage(),
                'total' => $bookings->total(),
            ],
        ]);
    }

    public function store(CreateBookingRequest $request): JsonResponse
    {
        try {
            $customer = $request->user()->customer;
            if (!$customer) {
                return response()->json(['message' => 'Customer profile not found.'], 404);
            }

            $booking = $this->bookingService->createBooking($customer, $request->validated());
            $booking->load(['service', 'provider', 'customer']);

            return response()->json([
                'message' => 'Booking created successfully.',
                'data' => new BookingResource($booking),
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function show(Request $request, Booking $booking): JsonResponse
    {
        if ($booking->customer->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        return response()->json(['data' => new BookingResource($booking->load(['service', 'provider']))]);
    }

    public function cancel(CancelBookingRequest $request, Booking $booking): JsonResponse
    {
        try {
            if ($booking->customer->user_id !== $request->user()->id) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }

            $booking = $this->bookingService->cancelBooking($booking, $request->validated()['cancellation_reason']);

            return response()->json([
                'message' => 'Booking cancelled successfully.',
                'data' => new BookingResource($booking->load(['service', 'provider'])),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function reschedule(Request $request, Booking $booking): JsonResponse
    {
        try {
            $request->validate(['new_start_time' => ['required', 'date', 'after:now']]);
            
            if ($booking->customer->user_id !== $request->user()->id) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }

            $booking = $this->bookingService->rescheduleBooking($booking, Carbon::parse($request->new_start_time));

            return response()->json([
                'message' => 'Booking rescheduled successfully.',
                'data' => new BookingResource($booking->load(['service', 'provider'])),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function adminIndex(Request $request): JsonResponse
    {
        $bookings = Booking::with(['customer', 'service', 'provider'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest('start_time')
            ->paginate(20);

        return response()->json([
            'data' => BookingResource::collection($bookings->items()),
            'meta' => ['total' => $bookings->total()],
        ]);
    }

    public function approve(Request $request, Booking $booking): JsonResponse
    {
        if ($booking->status !== 'pending') {
            return response()->json(['message' => 'Only pending bookings can be approved.'], 422);
        }

        $booking->update(['status' => 'confirmed']);
        return response()->json(['message' => 'Booking approved.', 'data' => new BookingResource($booking)]);
    }
}
