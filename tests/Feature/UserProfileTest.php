<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_401()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get(
            '/api/auth/me'
        );

        $response->assertStatus(401);
    }

    public function test_user()
    {
        $user = User::create(
            ['email' => 'dave@kumu.ph', 'password' => Hash::make('123456678'), 'name' => 'Dave']
        );

        $token = $user->createToken('API Token');

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ])->get(
            '/api/auth/me'
        );

        $response->assertStatus(200);
    }
}
