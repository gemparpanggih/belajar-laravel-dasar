<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseControllerTest extends TestCase
{
    public function testResponse()
    {
        $this->get('response/hello')->assertSeeText('Hello response')->assertStatus(200);
    }

    public function testHeader()
    {
        $this->get('/response/header')
            ->assertStatus(200)
            ->assertSeeText('gempar')
            ->assertSeeText('panggih')
            ->assertHeader('Content-Type', 'application/json')
            ->assertHeader('Author', 'gempar panggih')
            ->assertHeader('App', 'example_app');
    }

    public function testView()
    {
        $this->get('/response/type/view')->assertSeeText('hello gempar');
    }
    public function testJson()
    {
        $this->get('/response/type/json')->assertJson(['firstName' => 'gempar', 'lastName' => 'panggih']);
    }
    public function testFile()
    {
        $this->get('/response/type/file')->assertHeader('Content-Type', 'image/png');
    }
    public function testDownload()
    {
        $this->get('/response/type/download')->assertDownload('gemparpanggih.png');
    }
}
