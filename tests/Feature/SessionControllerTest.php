<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function testCreate() {
        $this->get('session/create')
            ->assertSeeText('OK')
            ->assertSessionHas('userId', 'gemparpanggih')
            ->assertSessionHas('isMember', 'true');
    }

    public function testGet() {
        $this->withSession([
            'userId' => 'gemparpanggih',
            'isMember' => 'true',
        ])->get('/session/get')
            ->assertSeeText('gemparpanggih')
            ->assertSeeText('true');
    }
    
    public function testGetFailed() {
        $this->withSession([
        ])->get('/session/get')
            ->assertSeeText('guest')
            ->assertSeeText('false');
    }
}
