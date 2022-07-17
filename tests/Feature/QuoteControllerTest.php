<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class QuoteControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic test for quotes api.
     *
     * @return void
     */
    public function test_quotes_api()
    {
        $login_response = $this->post('/api/login', [
            'name' => User::first()->name,
            'password' => 'password'
        ])->getOriginalContent();

        $response = $this->get('api/quotes', [
            'Authorization' => 'Bearer '.$login_response["access_token"],
            'Accept' => 'application/json'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(5)
            ->assertJsonStructure([
                    '*' => [
                        'id',
                        'quote',
                        'image'
                    ],
                ]);
    }
    /**
     * A basic test for api authentication
     *
     * @return void
     */
    public function test_api_auth()
    {
        $response = $this->get('api/quotes', [
            'Authorization' => 'Bearer '.$this->faker->word(),
            'Accept' => 'application/json'
        ]);

        $response
            ->assertStatus(401);
    }
}
