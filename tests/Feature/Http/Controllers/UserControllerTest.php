<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserController
 */
class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function post_edit_user_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->post(route('postEditUser'), [
            // TODO: send request data
        ]);

        $response->assertOk();

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_edit_user_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get(route('showEditUser'));

        $response->assertOk();
        $response->assertViewIs('ManageUser.Modals.EditUser');

        // TODO: perform additional assertions
    }

    // test cases...
}
