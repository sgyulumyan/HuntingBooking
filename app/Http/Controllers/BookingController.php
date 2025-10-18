<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\HuntingBookingResource;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request, BookingService $bookingService): JsonResponse
    {
        $booking = $bookingService->createBooking($request->validated())->load('guide');

        return (new HuntingBookingResource($booking))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
