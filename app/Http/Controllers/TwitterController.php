<?php

namespace App\Http\Controllers;

use App\Http\Requests\twitter\SaveCredentialsRequest;
use App\Http\Services\TwitterService;
use App\Models\TwitterCredential;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TwitterController extends Controller
{
    public function __construct(private TwitterService $twitterService)
    {}

    /**
     * The authenticate method should return a redirect to the twitter authentication page.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $url = $this->twitterService->getAuthenticationUrl();
        return Redirect($url);
    }

    /**
     * The saveCredentials method should save the given token and verifier in the database, related to the user.
     */
    public function saveCredentials(SaveCredentialsRequest $request): RedirectResponse
    {
        if (!session()->has('oauth_token_secret')) return Redirect()->route('twitter_authenticate'); // TODO: Should return to twitter dashboard with error message instead of retrying the whole authentication process.
        $fields = $request->validated();

        $user = auth()->user();

        $accessToken = $this->twitterService->getUserAccessToken($fields['oauth_token'], $fields['oauth_verifier'], session()->get('oauth_token_secret'));
        $twitterCredential = new TwitterCredential(['oauth_token' => $accessToken['oauth_token'], 'oauth_token_secret' => $accessToken['oauth_token_secret']]);
        $user->twitterCredentials()->save($twitterCredential);

        return Redirect()->route('home');
    }
}
