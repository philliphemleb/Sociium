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
            'email' => 'TestUser@examplemail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ];
    }

    public function testUserRegistration()
    {
        $this->post('register', $this->userData);

        $user = User::where('email', $this->userData['email'])->first();

        $this->assertDatabaseHas('users', [
            'first_name' => $this->userData['first_name'],
            'last_name' => $this->userData['last_name'],
            'email' => $this->userData['email'],
        ]);
        $this->assertTrue(Hash::check($this->userData['password'], $user['password']));
    }

    public function testUserIsRedirectingToLoginPageOnSuccess()
    {
        $request = $this->post('register', $this->userData);

        $request->assertRedirect('/login');
    }

    public function testUserRegistrationShouldThrowErrorIfTheGivenDataIsInvalid()
    {
        $this->userData['email'] = "NotAnValidEmail";

        $request = $this->post('register', $this->userData);

        $request->assertSessionHasErrors();
    }

    public function testUserLoginShouldRedirectOnSuccess()
    {
        $password = 'TestPassword';
        $user = User::factory()->state(['password' => Hash::make($password)])->create();

        $request = $this->post('/login', ['email' => $user->email, 'password' => 'TestPassword']);

        $request->assertRedirect('/');
    }

    public function testUserLoginShouldThrowErrorIfTheGivenDataIsInvalid()
    {
        $email = 'NotAValidEmail@email.com';
        $password = 'NotAValidPassword';

        $request = $this->post('/login', ['email' => $email, 'password' => $password]);

        $request->assertSessionHasErrors();
    }

    public function testUserLogoutShouldLogoutTheUserAsExpected()
    {
        $user = User::factory()->create();
        $this->be($user);

        $request = $this->post('/logout');

        $request->assertRedirect('/login');
        $this->assertGuest();
    }
}
