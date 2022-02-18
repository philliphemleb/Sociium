<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $userData;

    public function setUp(): void
    {
        parent::setUp();

        $this->userData = [
            'username' => 'name',
            'email' => 'TestUser@examplemail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ];
    }

    public function testUserRegistration()
    {
        $response = $this->post('/api/register', $this->userData);

        $user = User::where('email', $this->userData['email'])->first();

        $response->assertJsonStructure(
            [
                'user' => [
                    'username',
                    'email',
                    'updated_at',
                    'created_at',
                    'id',
                ],
                'token'
            ]
        );
        $this->assertDatabaseHas('users', [
            'username' => $this->userData['username'],
            'email' => $this->userData['email'],
        ]);
        $this->assertTrue(Hash::check($this->userData['password'], $user['password']));
    }

    public function testUserRegistrationShouldThrowErrorIfTheGivenDataIsInvalid()
    {
        $this->userData['email'] = "NotAnValidEmail";

        $response = $this->post('/api/register', $this->userData);

        $response->assertSessionHasErrors();
    }

    public function testUserLogin()
    {
        $password = 'TestPassword';
        $user = User::factory()->state(['password' => Hash::make($password)])->create();

        $response = $this->post('/api/login', ['email' => $user->email, 'password' => 'TestPassword']);

        $response->assertJsonStructure(['user', 'token']);
    }

    public function testUserLoginShouldThrowErrorIfTheGivenDataIsInvalid()
    {
        $email = 'NotExisting@email.com';
        $password = 'NotExistingPassword';

        $response = $this->post('/api/login', ['email' => $email, 'password' => $password]);

        $response->assertExactJson(['message' => 'auth.failed']);
    }

    public function testUserLogoutShouldLogoutTheUserAsExpected()
    {
        $user = User::factory()->create();
        $accessToken = $user->createToken('access_token')->plainTextToken;
        $this->be($user);

        $response = $this->delete('/api/logout');
        $response->assertExactJson(['message' => 'auth.logged_out']);

        $this->assertEmpty($user->tokens()->get());
    }
}
