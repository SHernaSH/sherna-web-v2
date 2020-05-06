<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, AdditionalAssertions;
}
