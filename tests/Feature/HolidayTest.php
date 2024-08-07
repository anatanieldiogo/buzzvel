<?php

namespace Tests\Feature;

use App\Models\Holiday;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class HolidayTest extends TestCase
{
    /**
     * Create Holiday
     */
    public function test_it_should_be_able_to_create_a_holiday(): void
    {
        $this->withoutExceptionHandling();

        $authenticatedUser = User::factory()->create();
        Sanctum::actingAs($authenticatedUser);

        $this->postJson('/api/holidays/', [
            'title' => 'Vacation plan',
            'description' => 'This is the description',
            'date' => '2024-08-26',
            'location' => 'Holiday location',
        ])
            ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('holidays', [
            'title' => 'Vacation plan',
            'description' => 'This is the description',
            'date' => '2024-08-26',
            'location' => 'Holiday location',
            'user_id' => $authenticatedUser->id,
        ]);
    }

    /**
     * Update a Holiday
     */
    public function test_it_should_be_able_to_update_a_holiday(): void
    {
        $this->withoutExceptionHandling();

        $authenticatedUser = User::factory()->create();
        Sanctum::actingAs($authenticatedUser);

        $holiday = Holiday::factory()->create([
            'user_id' => $authenticatedUser->id,
            'title' => 'Original title',
            'description' => 'Original description',
            'date' => '2024-08-26',
            'location' => 'Original location',
        ]);

        $response = $this->putJson("/api/holidays/{$holiday->id}", [
            'title' => 'Updated title',
            'description' => 'Updated description',
            'date' => '2024-09-01',
            'location' => 'Updated location',
        ])
            ->assertStatus(201);

        $this->assertDatabaseHas('holidays', [
            'id' => $holiday->id,
            'title' => 'Updated title',
            'description' => 'Updated description',
            'date' => '2024-09-01',
            'location' => 'Updated location',
            'user_id' => $authenticatedUser->id,
        ]);
    }

    /**
     * Delete a Holiday
     */
    public function test_it_should_be_able_to_delete_a_holiday(): void
    {
        $this->withoutExceptionHandling();

        $authenticatedUser = User::factory()->create();
        Sanctum::actingAs($authenticatedUser);

        $holiday = Holiday::factory()->create([
            'user_id' => $authenticatedUser->id,
            'title' => 'Original title',
            'description' => 'Original description',
            'date' => '2024-08-26',
            'location' => 'Original location',
        ]);

        $response = $this->delete("/api/holidays/{$holiday->id}")
            ->assertStatus(201);

        $this->assertDatabaseMissing('holidays', [
            'id' => $holiday->id,
        ]);
    }

    /**
     * Export a Holiday
     */
    public function test_it_should_be_able_to_export_a_holiday(): void
    {
        $this->withoutExceptionHandling();

        $authenticatedUser = User::factory()->create();
        Sanctum::actingAs($authenticatedUser);

        $holiday = Holiday::factory()->create(['user_id' => $authenticatedUser->id]);

        $response = $this->getJson("/api/export/holiday/{$holiday->id}")
            ->assertStatus(200);
    }
}
