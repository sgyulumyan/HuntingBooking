<?php

namespace Tests\Feature;

use App\Models\Guide;
use App\Models\HuntingBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class BookingApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_booking_when_guide_is_available(): void
    {
        $guide = Guide::factory()->active()->create();
        $payload = [
            'tour_name' => 'Autumn Hunt',
            'hunter_name' => 'John Doe',
            'guide_id' => $guide->id,
            'date' => Carbon::now()->addDays(5)->toDateString(),
            'participants_count' => 4,
        ];

        $response = $this->postJson('/api/bookings', $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('data.tour_name', $payload['tour_name'])
            ->assertJsonPath('data.guide.id', $guide->id);

        $this->assertDatabaseHas('hunting_bookings', [
            'guide_id' => $guide->id,
            'date' => Carbon::parse($payload['date'])->toDateTimeString(),
            'participants_count' => $payload['participants_count'],
        ]);
    }

    public function test_it_rejects_booking_when_guide_is_already_booked(): void
    {
        $guide = Guide::factory()->active()->create();
        $date = Carbon::now()->addDays(3)->toDateString();
        HuntingBooking::factory()->create([
            'guide_id' => $guide->id,
            'date' => $date,
        ]);

        $response = $this->postJson('/api/bookings', [
            'tour_name' => 'Winter Hunt',
            'hunter_name' => 'Jane Smith',
            'guide_id' => $guide->id,
            'date' => $date,
            'participants_count' => 2,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('date');
    }

    public function test_it_rejects_booking_when_participants_exceed_limit(): void
    {
        $guide = Guide::factory()->active()->create();

        $response = $this->postJson('/api/bookings', [
            'tour_name' => 'Spring Hunt',
            'hunter_name' => 'Anna Lee',
            'guide_id' => $guide->id,
            'date' => Carbon::now()->addWeek()->toDateString(),
            'participants_count' => 11,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('participants_count');
    }
}
