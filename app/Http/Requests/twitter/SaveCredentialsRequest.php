<?php

namespace App\Http\Requests\twitter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SaveCredentialsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'oauth_token' => 'required|string',
            'oauth_verifier' => 'required|string',
        ];
    }

    /**
     * Custom messages for validation
     */
    public function messages(): array
    {
        return [
            'oauth_token.required' => __('twitter.oauth_token_required'),
            'oauth_token.string' => __('twitter.oauth_token_must_be_string'),
            'oauth_verifier.required' => __('twitter.oauth_verifier_required'),
            'oauth_verifier.string' => __('twitter.oauth_verifier_must_be_string'),
        ];
    }
}
