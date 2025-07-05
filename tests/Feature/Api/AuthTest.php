<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a user can login with correct credentials', function () {
    //Creating a user to test with.
    $user = User::factory()->create([
        'password' => bcrypt('correct-password'),
    ]);

    // Making a POST request to the login endpoint.
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'correct-password',
    ]);

    // Checking for a successful status and the expected JSON structure.
    $response->assertStatus(200)
        ->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
});

test('a user cannot login with incorrect credentials', function () {
    $user = User::factory()->create([
        'password' => bcrypt('correct-password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    // Checking for a 401 Unauthorized status and the correct error message.
    $response->assertStatus(401)
        ->assertJson(['error' => 'Invalid credentials']);
});