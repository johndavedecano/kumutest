<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_error()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/auth/register', ['email' => 'dave@kumu.ph', 'password' => 'password']);

        $response->assertStatus(422);
    }

    public function test_successfull_request()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post(
            '/api/auth/register',
            [
                'email' => 'dave@kumu.ph',
                'password' => 'password',
                'name' => 'dave',
                'password_confirmation' => 'password'
            ]
        );

        $response->assertStatus(200);
    }
}
