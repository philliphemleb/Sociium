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
            'first_name' => 'first',
            'last_name' => 'last',
            'email_address' => 'TestUser@examplemail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ];
    }

    public function testUserRegistration()
    {
        $response = $this->post('/api/register', $this->userData);

        $user = User::where('email', $this->userData['email_address'])->first();

        $response->assertJsonStructure(
            [
                'user' => [
                    'first_name',
                    'last_name',
                    'email',
                    'updated_at',
                    'created_at',
                    'id',
                ],
                'token'
            ]
        );
        $this->assertDatabaseHas('users', [
            'first_name' => $this->userData['first_name'],
            'last_name' => $this->userData['last_name'],
            'email' => $this->userData['email_address'],
        ]);
        $this->assertTrue(Hash::check($this->userData['password'], $user['password']));
    }

    public function testUserRegistrationShouldThrowErrorIfTheGivenDataIsInvalid()
    {
        $this->userData['email_address'] = "NotAnValidEmail";

        $response = $this->post('/api/register', $this->userData);

        $response->assertSessionHasErrors();
    }

    public function testUserLogin()
    {
        $password = 'TestPassword';
        $user = User::factory()->state(['password' => Hash::make($password)])->create();

        $response = $this->post('/api/login', ['email' => $user->email, 'password' => 'TestPassword']);

        $response->assertJsonStructure(['token']);
    }

    public function testUserLoginShouldThrowErrorIfTheGivenDataIsInvalid()
    {
        $email = 'NotExistingEmail@email.com';
        $password = 'NotExistingPassword';

        $response = $this->post('/api/login', ['email' => $email, 'password' => $password]);

        $response->assertSessionHasErrors();
    }

    public function testUserLogoutShouldLogoutTheUserAsExpected()
    {
        $user = User::factory()->create();
        $this->be($user);

        $response = $this->post('/logout');

        $response->assertExactJson([true]);
        $this->assertGuest();
    }
}
