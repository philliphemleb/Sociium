<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|alpha|max:30',
            'last_name' => 'required|alpha|max:30',
            'email' => 'required|email|string|max:255|unique:users,email',
            'password' => 'required|string|confirmed'
        ];
    }

    /**
     * Custom messages for validation
     */
    public function messages(): array
    {
        return [
            'first_name.required' => __('auth.first_name_required'),
            'first_name.alpha' => __('auth.first_name_only_alpha'),
            'first_name.max' => __('auth.first_name_max_characters'),
            'last_name.required' => __('auth.last_name_required'),
            'last_name.alpha' => __('auth.last_name_only_alpha'),
            'last_name.max' => __('auth.last_name_max_characters'),
            'email.required' => __('auth.email_required'),
            'email.email' => __('auth.email_must_be_email'),
            'email.string' => __('auth.email_must_be_string'),
            'email.max' => __('auth.email_max_characters'),
            'email.unique' => __('auth.email_unique'),
            'password.required' => __('auth.password_required'),
            'password.string' => __('auth.password_must_be_string'),
            'password.confirmed' => __('auth.password_must_be_confirmed')
        ];
    }
}
