<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Throwable;

class TwitterControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'oauth_token' => 'token',
            'oauth_verifier' => 'verifier',
        ];
    }

    /**
     * This test checks if the authentication method in TwitterController is redirecting the user as expected.
     *
     * @return void
     */
    public function testAuthenticationUserWillBeRedirectedToTwitterForAuthentication()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/twitter/authenticate', ['Accept' => 'application/json']);

        $response->assertRedirect();
    }

    /**
     * This test checks if the saveCredentials method in TwitterController is saving the twitter credentials as expected.
     *
     * @return void
     * @throws Throwable
     */
    public function testTwitterCredentialsUserCanSaveTwitterCredentials()
    {
        $user = User::factory()->create();

        $url = '/api/twitter/saveCredentials?oauth_token='. $this->data['oauth_token'] .'&oauth_verifier='. $this->data['oauth_verifier'];
        $response = $this->actingAs($user)->get($url, ['Accept' => 'application/json']);

        $response->assertStatus(201)->assertExactJson([true]);
        $this->assertDatabaseHas('twitter_credentials', [
            'user_id' => $user->id,
            'oauth_token' => $this->data['oauth_token'],
            'oauth_verifier' => $this->data['oauth_verifier']
        ]);
    }

    /**
     * This test checks if the saveCredentials method in TwitterController is returns false on failure.
     *
     * @return void
     * @throws Throwable
     */
    public function testTwitterCredentialsUserGetsStatusCode500InFailure()
    {
        $user = User::factory()->create();

        $url = '/api/twitter/saveCredentials?oauth_token='. $this->data['oauth_token'];
        $response = $this->actingAs($user)->get($url, ['Accept' => 'application/json']);

        $response->assertStatus(500)->assertExactJson([false]);
    }
}
