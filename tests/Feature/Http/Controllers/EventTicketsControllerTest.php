<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventTicketsController
 */
class EventTicketsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function post_create_ticket_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->post(route('postCreateTicket', ['event_id' => $event_id]), [
            // TODO: send request data
        ]);

        $response->assertOk();

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function post_delete_ticket_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $ticket = factory(\App\Models\Ticket::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->post(route('postDeleteTicket', ['event_id' => $event_id]), [
            // TODO: send request data
        ]);

        $response->assertOk();

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function post_edit_ticket_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $ticket = factory(\App\Models\Ticket::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->post(route('postEditTicket', ['event_id' => $event_id, 'ticket_id' => $ticket_id]), [
            // TODO: send request data
        ]);

        $response->assertOk();

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function post_pause_ticket_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $ticket = factory(\App\Models\Ticket::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->post(route('postPauseTicket', ['event_id' => $event_id]), [
            // TODO: send request data
        ]);

        $response->assertOk();

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function post_update_tickets_order_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $ticket = factory(\App\Models\Ticket::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->post(route('postUpdateTicketsOrder', ['event_id' => $event_id]), [
            // TODO: send request data
        ]);

        $response->assertOk();

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_create_ticket_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $event = factory(\App\Models\Event::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get(route('showCreateTicket', ['event_id' => $event_id]));

        $response->assertOk();
        $response->assertViewIs('ManageEvent.Modals.CreateTicket');
        $response->assertViewHas('event', $event);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_edit_ticket_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $event = factory(\App\Models\Event::class)->create();
        $ticket = factory(\App\Models\Ticket::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get(route('showEditTicket', ['event_id' => $event_id, 'ticket_id' => $ticket_id]));

        $response->assertOk();
        $response->assertViewIs('ManageEvent.Modals.EditTicket');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_tickets_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $event = factory(\App\Models\Event::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get(route('showEventTickets', ['event_id' => $event_id]));

        $response->assertOk();
        $response->assertViewIs('ManageEvent.Tickets');
        $response->assertViewHas('event', $event);
        $response->assertViewHas('tickets');
        $response->assertViewHas('sort_by');
        $response->assertViewHas('q');
        $response->assertViewHas('allowed_sorts');

        // TODO: perform additional assertions
    }

    // test cases...
}