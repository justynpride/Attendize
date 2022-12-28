<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrganiserController
 */
class OrganiserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function post_create_organiser_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->post(route('postCreateOrganiser'), [
            // TODO: send request data
        ]);

        $response->assertOk();

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_create_organiser_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get(route('showCreateOrganiser'));

        $response->assertOk();
        $response->assertViewIs('ManageOrganiser.CreateOrganiser');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_select_organiser_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get(route('showSelectOrganiser'));

        $response->assertOk();
        $response->assertViewIs('ManageOrganiser.SelectOrganiser');

        // TODO: perform additional assertions
    }

    // test cases...
}