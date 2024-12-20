<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validates_user_creation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('user.store'), [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'notmatching',
            'role' => '',
        ]);

        $response->assertRedirect(route('user.create'));
        $response->assertSessionHasErrors(['name', 'email', 'password', 'role']);
    }

    /** @test */
    public function it_creates_user_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('user.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
        $response->assertRedirect(route('user.list'));
        $response->assertSessionHas('success', 'User created successfully!');
    }

    /** @test */
    public function it_handles_duplicate_email_error()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $response = $this->post(route('user.store'), [
            'name' => 'John Smith',
            'email' => 'jane@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user',
        ]);

        $response->assertRedirect(route('user.create'));
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function it_handles_general_exceptions()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        \Mockery::mock('alias:App\Models\User')->shouldReceive('create')->andThrow(new \Exception('Database error'));

        $response = $this->post(route('user.store'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password123!',
            'password_confirmation' => 'password123!',
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('user.create'));
        $response->assertSessionHas('error', 'An error occurred: Database error');
    }

    /** @test */
    public function it_requires_role_to_be_valid()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('user.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'invalid_role',
        ]);

        $response->assertRedirect(route('user.create'));
        $response->assertSessionHasErrors(['role']);
    }
}

