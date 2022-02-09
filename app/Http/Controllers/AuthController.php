<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * this method should check the given data and then create the user.
     */
    public function register(RegisterRequest $request): Response
    {
        $fields = $request->validated();

        $user = User::create(
            [
                'username' => $fields['username'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password'])
            ]
        );

        $token = $user->createToken('personal_access_token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * The authenticate method should validate the given data and log in the user.
     */
    public function login(LoginRequest $request): Response
    {
        $fields = $request->validated();

        $email = $fields['email'];
        $password = $fields['password'];

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password))
        {
            return response(['message' => __('auth.failed')], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('access_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    /**
     * The logout method should invalidate the session and regenerate the CSRF Token before returning a success message.
     */
    public function logout(Request $request): Response
    {
        Auth()->user()->tokens()->delete();

        $response = [
            'message' => __('auth.logged_out'),
        ];

        return response($response, 201);
    }
}
