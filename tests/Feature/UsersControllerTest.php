<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\UsersRepository;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_401()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/users');

        $response->assertStatus(401);
    }

    public function test_validation_ok()
    {
        $user = User::create(
            ['email' => 'dave@kumu.ph', 'password' => Hash::make('123456678'), 'name' => 'Dave']
        );

        $token = $user->createToken('API Token');

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ])->get('/api/users');

        $response->assertStatus(200);
    }
}
