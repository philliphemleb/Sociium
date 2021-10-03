<?php

namespace Tests\Unit\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private $userData;

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

    /**
     * This test checks if the register method in AuthController is saving the user as expected.
     *
     * @return void
     */
    public function testUserRegistrationSavesUserInDatabase()
    {
        $this->post('/api/register', $this->userData, ['Accept' => 'application/json']);

        $this->assertDatabaseHas('users', [
            'first_name' => $this->userData['first_name'],
            'last_name' => $this->userData['last_name'],
            'email' => $this->userData['email']
        ]);
    }

    /**
     * This test checks if the register method in AuthController does hash the password as expected.
     *
     * @return void
     */
    public function testUserRegistrationShouldHashThePasswordAsExpected()
    {
        $this->post('/api/register', $this->userData, ['Accept' => 'application/json']);

        $user = User::where('email', $this->userData['email'])->first();

        $this->assertTrue(Hash::check($this->userData['password'], $user['password']));
    }

    /**
     * This test checks if the register method in AuthController returns the expected user data.
     *
     * @return void
     * @throws \Throwable
     */
    public function testUserRegistrationShouldReturnUserData()
    {
        $response = $this->post('/api/register', $this->userData, ['Accept' => 'application/json']);
        $content = $response->decodeResponseJson();

        $content->assertStructure([
            'user' => [
                'first_name',
                'last_name',
                'email'
            ],
            'token',
        ]);
        $response->assertStatus(201);
    }

    /**
     * This test checks if the register method in AuthController throws an error if data is invalid.
     *
     * @return void
     * @throws \Throwable
     */
    public function testUserRegistrationShouldThrowErrorIfTheGivenDataIsInvalid()
    {
        $this->userData['email'] = "NotAnValidEmail";

        $response = $this->post('/api/register', $this->userData, ['Accept' => 'application/json']);
        $content = $response->decodeResponseJson();

        $content->assertStructure([
            'message',
            'errors' => [
                'email'
            ]
        ]);
        $response->assertStatus(422);
    }

    /**
     * This test checks if the login method in AuthController returns the expected user data.
     *
     * @return void
     * @throws \Throwable
     */
    public function testUserLoginShouldReturnUserData()
    {
        $password = 'TestPassword';
        $user = User::factory()->state(['password' => Hash::make($password)])->create();

        $response = $this->post('/api/login', ['email' => $user->email, 'password' => 'TestPassword']);
        $content = $response->decodeResponseJson();

        $content->assertStructure([
            'token',
        ]);
        $response->assertStatus(200);
    }

    /**
     * This test checks if the login method in AuthController throws an error if the data is invalid.
     *
     * @return void
     * @throws \Throwable
     */
    public function testUserLoginShouldThrowErrorIfTheGivenDataIsInvalid()
    {
        $response = $this->post('/api/login', ['email' => 'NotAValidEmail@email.com', 'password' => 'NotAValidPassword']);
        $content = $response->decodeResponseJson();

        $content->assertStructure([
            'message',
        ]);
        $response->assertStatus(401);
    }

    /**
     * This test checks if the logout method in AuthController deletes the personal_token as expected.
     *
     * @return void
     */
    public function testUserLogoutShouldDeleteTheTokenAsExpected()
    {
        $user = User::factory()->create();
        $token = $user->createToken('personal_token')->plainTextToken;

        $response = $this->post('/api/logout', [], [
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}"
        ]);

        $this->assertEmpty($user->tokens()->get());
        $response->assertStatus(200);
    }
}
