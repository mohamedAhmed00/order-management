<?php

namespace Feature;

use App\Models\User;

class LoginTest
{
    public function test_user_can_login_and_receive_token()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret123'),
        ]);
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'secret123',
        ]);
        $response->assertStatus(200)->assertJsonStructure(['token']);
    }
}
