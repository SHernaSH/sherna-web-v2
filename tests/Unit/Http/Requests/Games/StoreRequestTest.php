<?php

namespace Tests\Unit\Http\Requests\Games;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Games\StoreRequest
 */
class StoreRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Games\StoreRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Games\StoreRequest();
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
                'required',
                'string',
                'max:255',
            ],
            'possible_players' => [
                'required',
                'integer',
                'min:1',
            ],
            'console_id' => [
                'required',
                'exists:consoles,id',
            ],
            'serial_id' => ['required'],
            'inventory_id' => ['required'],
        ], $actual);
    }

    // test cases...
}