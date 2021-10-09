<?php

namespace Tests\Feature\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Factories\TwitterOAuthFactory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
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
            'oauth_token_secret' => 'secret',
            'oauth_verifier' => 'verifier',
            'user_token' => "28325-o2KPOBVzWhUc20P6HIZZETeYCidDS3x",
            'user_secret' => "njcEh4HkQuzidOsTfc2rpXjhu6St6xt39lK1JiBannX6rX",
        ];
    }

    /**
     * This test checks if the authentication method in TwitterController is redirecting the user as expected.
     *
     * @return void
     */
    public function testUserWillBeRedirectedToTwitterForAuthentication()
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
    public function testUserCanSaveTwitterCredentials()
    {
        $user = User::factory()->create();
        $url = '/api/twitter/saveCredentials?oauth_token=' . $this->data['oauth_token'] . '&oauth_verifier=' . $this->data['oauth_verifier'];
        $this->session(['oauth_token_secret' => $this->data['oauth_token_secret']]);

        $mock = $this->mock(TwitterOAuthFactory::class, function (MockInterface $mock) {
            $twitterOAuthMock = Mockery::mock(TwitterOAuth::class, function (MockInterface $mock) {
                $mock->shouldReceive('oauth')->andReturn(['oauth_token' => $this->data['user_token'], 'oauth_token_secret' => $this->data['user_secret']]);
            });

            $mock->shouldReceive('createClientAuth')->once()->with($this->data['oauth_token'], $this->data['oauth_token_secret'])->andReturn($twitterOAuthMock);
        });

        $response = $this->actingAs($user)->get($url, ['Accept' => 'application/json']);

        $response->assertStatus(201)->assertExactJson(['status' => true]);
        $this->assertDatabaseHas('twitter_credentials', [
            'user_id' => $user->id,
            'oauth_token' => $this->data['user_token'],
            'oauth_token_secret' => $this->data['user_secret']
        ]);
    }

    /**
     * This test checks if the saveCredentials method in TwitterController is returns false on failure.
     *
     * @return void
     * @throws Throwable
     */
    public function testUserGetsStatusCode500AtFailureOnSaveCredentials()
    {
        $user = User::factory()->create();
        $url = '/api/twitter/saveCredentials?oauth_token=' . $this->data['oauth_token'];
        $this->session(['oauth_token_secret' => $this->data['oauth_token_secret']]);

        $response = $this->actingAs($user)->get($url, ['Accept' => 'application/json']);

        $response->assertStatus(500)->assertJsonStructure(['status', 'message']);
    }

    public function testUserWillBeRedirectedToAuthenticationPageIfTheSecretIsNotGiven()
    {
        $user = User::factory()->create();
        $url = '/api/twitter/saveCredentials?oauth_token=' . $this->data['oauth_token'] . '&oauth_verifier=' . $this->data['oauth_verifier'];

        $response = $this->actingAs($user)->get($url, ['Accept' => 'application/json']);

        $response->assertRedirectToSignedRoute('twitter_authenticate');
    }
}
