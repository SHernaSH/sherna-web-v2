<?php

namespace Tests\Unit\Http\Requests\Article\ArticleCategory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Article\ArticleCategory\StoreRequest
 */
class StoreRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Article\ArticleCategory\StoreRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Article\ArticleCategory\StoreRequest();
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
