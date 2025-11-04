<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Service::active()->get();
        return response()->json(['data' => ServiceResource::collection($services)]);
    }

    public function show(Service $service): JsonResponse
    {
        return response()->json(['data' => new ServiceResource($service)]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration_minutes' => ['required', 'integer', 'min:15'],
            'buffer_time_minutes' => ['nullable', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'deposit_amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $service = Service::create($validated);
        
        return response()->json([
            'message' => 'Service created successfully.',
            'data' => new ServiceResource($service)
        ], 201);
    }

    public function update(Request $request, Service $service): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration_minutes' => ['sometimes', 'integer', 'min:15'],
            'buffer_time_minutes' => ['nullable', 'integer', 'min:0'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'deposit_amount' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $service->update($validated);

        return response()->json([
            'message' => 'Service updated successfully.',
            'data' => new ServiceResource($service)
        ]);
    }

    public function destroy(Service $service): JsonResponse
    {
        $service->update(['is_active' => false]);
        
        return response()->json(['message' => 'Service deactivated successfully.']);
    }
}
