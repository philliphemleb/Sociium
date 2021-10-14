<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Custom messages for validation
     */
    public function messages(): array
    {
        return [
            'email.required' => __('auth.email_required'),
            'email.email' => __('auth.email_must_be_email'),
            'email.string' => __('auth.email_must_be_string'),
            'password.required' => __('auth.password_required'),
            'password.string' => __('auth.password_must_be_string'),
        ];
    }
}
