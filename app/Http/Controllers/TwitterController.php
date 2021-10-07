<?php

namespace App\Http\Controllers;

use App\Http\Services\TwitterService;
use App\Models\TwitterCredential;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class TwitterController extends Controller
{
    public function __construct(private TwitterService $twitterService)
    {
        
    }

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

            $user->twitterCredentials()->save($twitterCredential);
        } catch (Throwable) {
            return Response()->json([false], 500);
        }

        return Response()->json([true], 201);
    }
}
