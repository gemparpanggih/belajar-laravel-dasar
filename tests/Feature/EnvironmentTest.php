<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    public function testEnv()
    {
        $appName = env("Koding Indonesia");

        self::assertEquals("", $appName);
    }
}
