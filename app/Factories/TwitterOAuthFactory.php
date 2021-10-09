<?php
declare(strict_types=1);

namespace App\Factories;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;
use Illuminate\Support\Env;

class TwitterOAuthFactory
{
    /**
     * @throws TwitterOAuthException
     */
    public function createAppAuth(): TwitterOAuth
    {
        $TWITTER_API_VERSION = Env::get('TWITTER_API_VERSION');
        $TWITTER_CONSUMER_KEY = Env::get('TWITTER_CONSUMER_KEY');
        $TWITTER_CONSUMER_SECRET = Env::get('TWITTER_CONSUMER_SECRET');

        return tap(new TwitterOAuth($TWITTER_CONSUMER_KEY, $TWITTER_CONSUMER_SECRET), function(TwitterOAuth $instance) use ($TWITTER_API_VERSION) {
            $instance->setApiVersion($TWITTER_API_VERSION);
        });
    }

    /**
     * @throws TwitterOAuthException
     */
    public function createClientAuth(string $oauthToken, string $oauthTokenSecret): TwitterOAuth
    {
        $TWITTER_API_VERSION = Env::get('TWITTER_API_VERSION');
        $TWITTER_CONSUMER_KEY = Env::get('TWITTER_CONSUMER_KEY');
        $TWITTER_CONSUMER_SECRET = Env::get('TWITTER_CONSUMER_SECRET');

        return tap(new TwitterOAuth($TWITTER_CONSUMER_KEY, $TWITTER_CONSUMER_SECRET, $oauthToken, $oauthTokenSecret), function(TwitterOAuth $instance) use ($TWITTER_API_VERSION) {
            $instance->setApiVersion($TWITTER_API_VERSION);
        });
    }
}
