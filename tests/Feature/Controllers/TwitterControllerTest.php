<?php

namespace Tests\Feature\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Factories\TwitterOAuthFactory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

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

    public function testUserWillBeRedirectedToTwitterForAuthentication()
    {
        $user = User::factory()->create();

        $request = $this->actingAs($user)->get('/twitter/authenticate');

        $request->assertRedirect();
    }

    public function testUserCanSaveTwitterCredentials()
    {
        $user = User::factory()->create();
        $this->session(['oauth_token_secret' => $this->data['oauth_token_secret']]);

        $this->mock(TwitterOAuthFactory::class, function (MockInterface $mock) {
            $twitterOAuthMock = Mockery::mock(TwitterOAuth::class, function (MockInterface $mock) {
                $mock->shouldReceive('oauth')->andReturn(['oauth_token' => $this->data['user_token'], 'oauth_token_secret' => $this->data['user_secret']]);
            });

            $mock->shouldReceive('createClientAuth')->once()->with($this->data['oauth_token'], $this->data['oauth_token_secret'])->andReturn($twitterOAuthMock);
        });

        $url = '/twitter/saveCredentials?oauth_token=' . $this->data['oauth_token'] . '&oauth_verifier=' . $this->data['oauth_verifier'];
        $this->actingAs($user)->get($url);

        $this->assertDatabaseHas('twitter_credentials', [
            'user_id' => $user->id,
            'oauth_token' => $this->data['user_token'],
            'oauth_token_secret' => $this->data['user_secret']
        ]);
    }

    public function testUserGetsErrorOnSaveCredentialsIfDataIsInvalid()
    {
        // TODO (Ticket: PA-13)

        $this->fail();
    }

    public function testUserWillBeRedirectedToAuthenticationPageIfTheSecretIsNotGiven()
    {
        $user = User::factory()->create();

        $url = '/twitter/saveCredentials?oauth_token=' . $this->data['oauth_token'] . '&oauth_verifier=' . $this->data['oauth_verifier'];
        $response = $this->actingAs($user)->get($url);

        $response->assertRedirect('/twitter/authenticate');
    }
}
