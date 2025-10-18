<?php

namespace Tests\Feature;

use App\Models\Guide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuideApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_only_active_guides(): void
    {
        $active = Guide::factory()->active()->count(2)->create();
        Guide::factory()->inactive()->create();

        $response = $this->getJson('/api/guides');

        $response
            ->assertOk()
            ->assertJsonCount(2, 'data');

        foreach ($active as $guide) {
            $response->assertJsonFragment([
                'id' => $guide->id,
                'name' => $guide->name,
            ]);
        }
    }

    public function test_it_filters_guides_by_min_experience(): void
    {
        $junior = Guide::factory()->active()->create(['experience_years' => 2]);
        $mid = Guide::factory()->active()->create(['experience_years' => 3]);
        $senior = Guide::factory()->active()->create(['experience_years' => 7]);

        $response = $this->getJson('/api/guides?min_experience=3');

        $response
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonMissing(['id' => $junior->id])
            ->assertJsonFragment(['id' => $mid->id])
            ->assertJsonFragment(['id' => $senior->id]);
    }
}
