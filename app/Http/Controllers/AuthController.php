<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * This method will prepare and show the register view.
     */
    public function register(Request $request): View
    {
        return view('auth.register');
    }

    /**
     * this method should check the given data and then create the user.
     */
    public function create(RegisterRequest $request): View|RedirectResponse
    {
        $fields = $request->validated();

        $user = User::create(
            [
                'first_name' => $fields['first_name'],
                'last_name' => $fields['last_name'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password'])
            ]
        );

        return redirect()->route('login');
    }

    /**
     * This method will prepare and show the login view.
     */
    public function login(Request $request): View
    {
        return view('auth.login');
    }

    /**
     * The login method should validate the given data and log in the user.
     */
    public function authenticate(LoginRequest $request): View|RedirectResponse
    {
        $fields = $request->validated();

        $email = $fields['email'];
        $password = $fields['password'];
        $remember = $request->has('remember');

        if (Auth::attempt(['email' => $email, 'password' => $password], $remember))
        {
            $request->session()->regenerate();

            return redirect()->intended();
        }
        return back()->withErrors([
           'email' => __('auth.failed'),
           'password' => __('auth.password')
        ]);
    }

    /**
     * The logout method should invalidate the session and regenerate the CSRF Token before returning a success message.
     */
    public function logout(Request $request): Response
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
