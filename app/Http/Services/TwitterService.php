<?php
declare(strict_types=1);

namespace App\Http\Services;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Env;

class TwitterService
{
    private string $TWITTER_API_VERSION;
    private string $TWITTER_CONSUMER_KEY;
    private string $TWITTER_CONSUMER_SECRET;

    private TwitterOAuth $connection;

    public function __construct()
    {
        $this->TWITTER_API_VERSION = Env::get('TWITTER_API_VERSION');
        $this->TWITTER_CONSUMER_KEY = Env::get('TWITTER_CONSUMER_KEY');
        $this->TWITTER_CONSUMER_SECRET = Env::get('TWITTER_CONSUMER_SECRET');

        $this->connection = new TwitterOAuth($this->TWITTER_CONSUMER_KEY, $this->TWITTER_CONSUMER_SECRET);
        $this->connection->setApiVersion($this->TWITTER_API_VERSION);
    }

    public function getAuthenticationUrl(): string
    {
        $requestToken = $this->connection->oauth('oauth/request_token');
        $oauthToken = $requestToken['oauth_token'];

        $url = $this->connection->url('oauth/authorize', ['oauth_token' => $oauthToken]);
        return $url;
    }
}
