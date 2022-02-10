<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->withSession(['linkcutter_token' => 'smthng'])->get('/login');
        $response->assertLocation('/');
    }

    public function test_logout()
    {
        $response = $this->get('/logout');
        $response->assertStatus(302);
        $response->assertLocation('/');
    }

    public function test_getCheckLogin()
    {
        $response = $this->get('/login/checkdata');
        $response->assertStatus(302);
    }
}