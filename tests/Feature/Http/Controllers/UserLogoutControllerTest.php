<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserLogoutController
 */
class UserLogoutControllerTest extends TestCase
{
    /**
     * @test
     */
    public function do_logout_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $response = $this->delete(route('logout'));

        $response->assertRedirect(to('/?logged_out=yup'));

        // TODO: perform additional assertions
    }

    // test cases...
}
