<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @var \App\User */
    protected $user;

    public function setUp() : void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function authenticate()
    {
        $this->postJson('/login', [
            'email' => $this->user->email,
            'password' => 'secret',
        ])
        ->assertSuccessful()
        ->assertJsonStructure(['token', 'expires_in'])
        ->assertJson(['token_type' => 'bearer']);
    }

    /** @test */
    public function fetch_the_current_user()
    {
        $this->actingAs($this->user)
            ->getJson('/user')
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'name', 'email']);
    }

    /** @test */
    public function log_out()
    {
        $token = $this->postJson('/login', [
            'email' => $this->user->email,
            'password' => 'secret',
        ])->json()['token'];

        $this->postJson("/logout?token=$token")
            ->assertSuccessful();

        $this->getJson("/user?token=$token")
            ->assertStatus(401);
    }
}
