<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;
use App\Models\TwitterCredential;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Throwable;

class TwitterController extends Controller
{
    private string $TWITTER_API_VERSION;
    private string $TWITTER_CONSUMER_KEY;
    private string $TWITTER_CONSUMER_SECRET;

    private TwitterOAuth $connection;

    /**
     * @throws TwitterOAuthException
     */
    public function __construct()
    {
        $this->TWITTER_API_VERSION = Env::get('TWITTER_API_VERSION');
        $this->TWITTER_CONSUMER_KEY = Env::get('TWITTER_CONSUMER_KEY');
        $this->TWITTER_CONSUMER_SECRET = Env::get('TWITTER_CONSUMER_SECRET');

        $this->connection = new TwitterOAuth($this->TWITTER_CONSUMER_KEY, $this->TWITTER_CONSUMER_SECRET);
        $this->connection->setApiVersion($this->TWITTER_API_VERSION);
    }

    /**
     * The authenticate method should return a redirect to the twitter authentication page.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws TwitterOAuthException
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $requestToken = $this->connection->oauth('oauth/request_token');
        $oauthToken = $requestToken['oauth_token'];

        $url = $this->connection->url('oauth/authorize', ['oauth_token' => $oauthToken]);
        return Redirect()->away($url);
    }

    /**
     * The saveCredentials method should save the given token and verifier in the database, related to the user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveCredentials(Request $request): JsonResponse
    {
        try
        {
            $user = auth()->user();

            $token = $request->get('oauth_token');
            $verifier = $request->get('oauth_verifier');
            $twitterCredential = new TwitterCredential(['oauth_token' => $token, 'oauth_verifier' => $verifier]);

            $saved = $user->twitterCredentials()->save($twitterCredential);
        } catch (Throwable) {
            return Response()->json([false], 500);
        }

        return Response()->json([true], 201);
    }
}
