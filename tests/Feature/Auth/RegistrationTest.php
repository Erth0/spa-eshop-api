<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_a_name()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_a_email()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_valid_email()
    {
        $this->json('POST', 'api/auth/register', [
            'email' => 'nope'
        ])->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_unique_email()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/register', [
            'email' => $user->email
        ])->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['password']);
    }

    public function test_it_registers_a_user()
    {
        $user = $this->json('POST', 'api/auth/register', [
            'name' => $name = 'Eluert',
            'email' => $email = 'eluert.mukja@icloud.com',
            'password' => 'password'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => $name
        ]);
    }

    public function test_it_returns_a_user_on_registration()
    {
        $user = $this->json('POST', 'api/auth/register', [
            'name' => 'Eluert',
            'email' => $email = 'eluert.mukja@icloud.com',
            'password' => 'password'
        ])->assertJsonFragment([
            'email' => $email
        ]);
    }
}
