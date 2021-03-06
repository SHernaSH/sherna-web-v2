<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Admin\AdminController
 */
class AdminControllerTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    /**
     * @test
     */
    public function invoke_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();

        $response = $this->actingAs($user)->get(route('admin.index'));

        $response->assertOk();
        $response->assertViewIs('admin.index');

        // TODO: perform additional assertions
    }

    // test cases...
}
