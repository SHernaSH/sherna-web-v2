<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\Rule;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\ContactRequest
 */
class ContactRequestTest extends TestCase
{
    /** @var \App\Http\Requests\ContactRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\ContactRequest();
    }

    /**
     * @test
     */
    public function rules()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'email' => [
                'required',
                'email',
            ],
            'message' => [
                'required',
                'string',
                'min:50',
            ],
            'year' => [
                'required',
                Rule::in(date('Y')),
            ],
        ], $actual);
    }

    // test cases...
}
