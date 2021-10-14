<?php
declare(strict_types=1);

namespace App\Http\Services;

use App\Factories\TwitterOAuthFactory;

class TwitterService
{
    public function __construct(private TwitterOAuthFactory $authFactory)
    {
    }

    public function getAuthenticationUrl(): string
    {
        $connection = $this->authFactory->createAppAuth();

        $requestToken = $connection->oauth('oauth/request_token');
        session(['oauth_token_secret' => $requestToken['oauth_token_secret']]);

        $url = $connection->url('oauth/authorize', ['oauth_token' => $requestToken['oauth_token']]);
        return $url;
    }

    public function getUserAccessToken(string $token, string $verifier, string $secret): array
    {
        $connection = $this->authFactory->createClientAuth($token, $secret);
        session()->forget('oauth_token_secret');

        return $connection->oauth('oauth/access_token', ['oauth_verifier' => $verifier]);
    }
}
