<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetSalesTest extends TestCase
{
    public function test_login()
    {
        $response = $this->get('/getsales');
        $response->assertSessionHas('page_obj');

        $response = $this->withSession(['linkcutter_token' => 'smthng'])->getJson('/getsales');
        $response->assertSessionHas('page_obj');
    }
}
