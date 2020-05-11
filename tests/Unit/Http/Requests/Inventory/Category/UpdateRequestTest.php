<?php

namespace Tests\Unit\Http\Requests\Inventory\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Inventory\Category\UpdateRequest
 */
class UpdateRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Inventory\Category\UpdateRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Inventory\Category\UpdateRequest();
    }

    /**
     * @test
     */
    public function rules()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $actual = $this->subject->rules();

        $this->assertEquals([], $actual);
    }

    // test cases...
}
