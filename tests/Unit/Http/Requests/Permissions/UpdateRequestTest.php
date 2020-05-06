<?php

namespace Tests\Unit\Http\Requests\Permissions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Permissions\UpdateRequest
 */
class UpdateRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Permissions\UpdateRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Permissions\UpdateRequest();
    }

    /**
     * @test
     */
    public function rules()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'name' => [
                'string',
                'min:3',
                'max:80',
            ],
            'description' => [
                'string',
                'min:5',
                'max:255',
            ],
        ], $actual);
    }

    // test cases...
}
