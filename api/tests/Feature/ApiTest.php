<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    // public function test_weather_endpoint_returns_a_successful_response()
    // {
    //     $response = $this->get('/weather?lat=40.7128&lon=74.0060');

    //     $response->assertStatus(200);
    // }

    // test getting the weather for a user
    // public function test_user_weather_endpoint_returns_a_successful_response()
    // {
    //     $user = User::factory()->create();

    //     $response = $this->get("/weather/{$user->id}");

    //     $response->assertStatus(200);
    // }

}
