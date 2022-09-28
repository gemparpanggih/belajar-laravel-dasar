<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testBasic()
    {
        $this->get('/gempar')->assertStatus(200)->assertSeeText("gempar");        
    }
    public function testRedirect()
    {
        $this->get('/gemparpanggih')->assertRedirect('/gempar');
    }
    public function testFallback()
    {
        $this->get('/404')->assertSeeText("404");
    }
    public function testView()
    {
        $this->get('hello1')->assertSeeText("hello gempar");
        $this->get('hello2')->assertSeeText("hello gempar");
        $this->get('hello-world')->assertSeeText("hello world");
    }

    public function testRouteParameters()
    {
        $this->get('/products/1')->assertSeeText("Products: 1");
        $this->get('/products/1/items/40')->assertSeeText("Products: 1, Items: 40");
    }

    public function testRoutingParameterRegex()
    {
        $this->get('/category/12345')->assertSeeText("Category: 12345");
        $this->get('/category/hijkl')->assertSeeText("404");
    }

    public function testRoutingOptionalParameter()
    {
        $this->get('/users/12345')->assertSeeText("User: 12345");
        $this->get('/users')->assertSeeText("404");
    }
    public function testRoutingConflict()
    {
        $this->get('/conflict/windah')->assertSeeText("conflict: windah");
        $this->get('/conflict/gempar')->assertSeeText("conflict: gempar");
    }
    public function testNamed()
    {
        $this->get('/produk/12345')->assertSeeText("products/12345");
        $this->get('/produk-redirect/12345')->assertSeeText("products/12345");
    }
    public function testViewWithoutRoute() {
        $this->view('hello', ['name' => 'gempar'])->assertSeeText('hello gempar');
    }
}
