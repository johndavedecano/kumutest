<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_invalid()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post(
            '/api/auth/login',
            ['email' => 'notfound@kumu.ph', 'password' => 'password']
        );

        $response->assertStatus(422);
    }

    public function test_wrong_password()
    {

        $user = User::create(
            ['email' => 'dave@kumu.ph', 'password' => Hash::make('password'), 'name' => 'Dave']
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post(
            '/api/auth/login',
            ['email' => $user->email, 'password' => '123456678']
        );

        $response->assertStatus(400);
    }

    public function test_login_ok()
    {
        $user = User::create(
            ['email' => 'dave@kumu.ph', 'password' => Hash::make('123456678'), 'name' => 'Dave']
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post(
            '/api/auth/login',
            ['email' => $user->email, 'password' => '123456678']
        );

        $response->assertStatus(200);
    }
}
