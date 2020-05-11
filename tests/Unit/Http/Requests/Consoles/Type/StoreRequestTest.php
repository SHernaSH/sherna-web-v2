<?php

namespace Tests\Unit\Http\Requests\Consoles\Type;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Consoles\Type\StoreRequest
 */
class StoreRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Consoles\Type\StoreRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Consoles\Type\StoreRequest();
    }

    /**
     * @test
     */
    public function rules()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'name' => 'required|string|max:255',
        ], $actual);
    }

    // test cases...
}
