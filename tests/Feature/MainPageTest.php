<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MainPageTest extends TestCase
{
    public function test_MainPage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}