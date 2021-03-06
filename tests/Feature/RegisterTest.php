<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends TestCase
{
    use WithFaker, DatabaseMigrations, RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $this->postJson('/api/register', [
            'first_name' => $this->faker()->firstName(),
            'last_name' => $this->faker()->lastName(),
            'email' => 'pedro@hotmail.com',
            'password' => 'password',
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['id', 'name', 'email']]);
    }

    public function test_user_cannot_register_using_a_fake_email_provider()
    {
        $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@cuvox.de',
            'password' => 'secret',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
