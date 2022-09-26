<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\App;

class AppEnviromentTest extends TestCase
{
    public function testEnvironment()
    {
        if(App::environment("local")){
            echo "logic in testing env" . PHP_EOL;
            self::assertTrue(true);
        }
    }
}
