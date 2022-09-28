<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class URLGenerationTest extends TestCase
{
    public function testCurrent() {
        $this->get('/url/current?name=gempar')
            ->assertSeeText('/url/current?name=gempar');
    }

    public function testNamed() {
        $this->get('/url/named')
            ->assertSeeText('/redirect/name/gempar');
    }

    public function testAction() {
        $this->get('/url/action')->assertSeeText('/form');
    }
}
