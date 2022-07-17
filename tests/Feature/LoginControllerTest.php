<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic test for login api.
     *
     * @return void
     */
    public function test_login_api()
    {
        $response = $this->post('/api/login', [
            'name' => User::first()->name,
            'password' => 'password'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
            ]);
    }

    /**
     * A basic test for login failure.
     *
     * @return void
     */
    public function test_login_fail()
    {
        $response = $this->post('/api/login', [
            'name' => $this->faker->word(),
            'password' => $this->faker->word()
        ]);

        $response
            ->assertStatus(401);
    }
}
