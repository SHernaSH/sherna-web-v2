<?php

namespace Tests\Feature\Http\Controllers\Client;

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Client\ContactController
 */
class ContactControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->faker = Faker::create();
//        Session::start();
//        Session::put(['_token' => csrf_token()]);
    }

    /**
     * @test
     */
    public function send_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $response = $this->post(route('contact.send'), [
            'email' => $this->faker->email,
            'message' => $this->faker->text . $this->faker->text,
            'year' => date('Y'),
        ]);

        $response->assertRedirect(route('contact.show'));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function send_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Client\ContactController::class,
            'send',
            \App\Http\Requests\ContactRequest::class
        );
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $response = $this->get(route('contact.show'));

        $response->assertOk();
        $response->assertViewIs('client.contact.show');

        // TODO: perform additional assertions
    }

    // test cases...
}
