<?php

namespace App\Http\Controllers;

use App\Http\Services\TwitterService;
use App\Models\TwitterCredential;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TwitterController extends Controller
{
    public function __construct(private TwitterService $twitterService)
    {}

    /**
     * The authenticate method should return a redirect to the twitter authentication page.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $url = $this->twitterService->getAuthenticationUrl();
        return Redirect()->away($url);
    }

    /**
     * The saveCredentials method should save the given token and verifier in the database, related to the user.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function saveCredentials(Request $request): JsonResponse|RedirectResponse
    {
        if (!$request->has('oauth_token') || !$request->has('oauth_verifier')) return Response()->json(['status' => false, 'message' => 'token and verifier are required.'], 500);

        $user = auth()->user();
        $twitterCredentials = $user->twitterCredentials;

        if (isset($twitterCredentials[0])) return Response()->json(['status' => false, 'message' => 'already exists.'], 500);
        if (!session()->has('oauth_token_secret')) return Redirect()->signedRoute('twitter_authenticate');

        $accessToken = $this->twitterService->getUserAccessToken($request->get('oauth_token'), $request->get('oauth_verifier'), session()->get('oauth_token_secret'));
        $twitterCredential = new TwitterCredential(['oauth_token' => $accessToken['oauth_token'], 'oauth_token_secret' => $accessToken['oauth_token_secret']]);
        $user->twitterCredentials()->save($twitterCredential);

        return Response()->json(['status' => true], 201);
    }
}
