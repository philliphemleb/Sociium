<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * The register method should check the given data, create the user and his personal token and should then return the user and the token.
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request): Response
    {
        $fields = $request->validate(
            [
                'first_name' => 'required|max:100',
                'last_name' => 'required|max:100',
                'email' => 'required|email|max:255',
                'password' => 'required|string|confirmed'
            ]
        );

        $user = User::create(
            [
                'first_name' => $fields['first_name'],
                'last_name' => $fields['last_name'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password'])
            ]
        );

        $token = $user->createToken('personal_token')->plainTextToken;

        $response =
            [
                'user' => $user,
                'token' => $token
            ];

        return response($response, 201);
    }

    /**
     * The login method should check the given data, create the personal token and should then return the token.
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request): Response
    {
        $fields = $request->validate(
            [
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]
        );

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password))
        {
            return response(['message' => 'Username or Password might be wrong'], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('personal_token')->plainTextToken;

        return response(['token' => $token]);
    }

    /**
     * The logout method should delete every active token before returning a success message.
     *
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request): Response
    {
        auth()->user()->tokens()->delete();

        $response =
            [
                'message' => 'Successfully logged out'
            ];

        return response($response, 200);
    }
}
