<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventDashboardController
 */
class EventDashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function redirect_to_dashboard_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get('event/{event_id}');

        $response->assertRedirect(action('EventDashboardController@showDashboard', ['event_id' => $event_id]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_dashboard_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $event = factory(\App\Models\Event::class)->create();
        $eventStats = factory(\App\Models\EventStats::class, 3)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get(route('showEventDashboard', ['event_id' => $event_id]));

        $response->assertOk();
        $response->assertViewIs('ManageEvent.Dashboard');

        // TODO: perform additional assertions
    }

    // test cases...
}