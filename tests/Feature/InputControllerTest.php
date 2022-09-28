<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput() {
        $this->get('/input/hello?name=gempar')->assertSeeText('Hello gempar');
        $this->post('/input/hello', ['name' => 'gempar'])->assertSeeText('Hello gempar');
    }

    public function testNestedInput() {
        $this->post('/input/hello/firstname', 
            ['name' => [ 
                    'first' => 'gempar',
                    'last' =>  'panggih'
                ]
        ])->assertSeeText('Hello gempar');
        
        $this->post('/input/hello/lastname', 
            ['name' => [ 
                    'first' => 'gempar',
                    'last' =>  'panggih'
                ]
        ])->assertSeeText('Hello panggih');
    }

    public function testInputAll() {
        $this->post('/input/hello/input', 
            ['name' => [ 
                    'first' => 'gempar',
                    'last' =>  'panggih'
                ]
        ])->assertSeeText('name')
            ->assertSeeText('first')
            ->assertSeeText('last')
            ->assertSeeText('gempar')
            ->assertSeeText('panggih');
    }

    public function testArrayInput() {
        $this->post('/input/hello/array',   [
            'products' => [
                    [
                        'name' => 'Iphone 14',
                        'price' => 10,
                    ],
                    [
                        'name' => 'Realme GT 3 PRO',
                        'price' => 20
                    ],
                ]
            ])->assertSeeText('Iphone 14')->assertSeeText('Realme GT 3 PRO');
    }
    
    public function testInputType() {
        $this->post('/input/type',  [
            'name' => 'gempar',
            'married' => 'false',
            'birth_date' => '1945-09-09',
        ])->assertSeeText('gempar')
            ->assertSeeText('false')
            ->assertSeeText('1945-09-09');
    }
    public function testFilterOnly() {
        $this->post('/input/filter/only',  [
            "name" => [
                'first' => 'gempar',
                'middle' => 'gak ada',
                'last' => 'panggih',
            ],
            'married' => 'false',
            'birth_date' => '1945-09-09',
        ])->assertSeeText('gempar')
            ->assertSeeText('panggih')
            ->assertDontSeeText('1945-09-09')
            ->assertDontSeeText('gak ada')
            ->assertDontSeeText('false');
    }
    public function testFilterExcpect() {
        $this->post('/input/filter/except',  [
            "name" => [
                'first' => 'gempar',
                'middle' => 'gak ada',
                'last' => 'panggih',
            ],
            'password' => 'rahasia',
            'married' => 'false',
            'birth_date' => '1945-09-09',
        ])->assertSeeText('gempar')
            ->assertSeeText('panggih')
            ->assertSeeText('1945-09-09')
            ->assertSeeText('gak ada')
            ->assertSeeText('false')
            ->assertDontSeeText('rahasia');
    }
    public function testFilterMerge() {
        $this->post('/input/filter/merge',  [
            "admin" => "true",
            "username" => "sebuah username",
            "password" => 'sebuah password',
        ])->assertSeeText('sebuah username')
            ->assertSeeText('sebuah password')
            ->assertSeeText('false');
    }
}
