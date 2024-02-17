<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationTrait;
use Illuminate\Validation\Rule;

class AuthRequest extends FormRequest
{
    use FailedValidationTrait;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return match(Route::currentRouteName()) {
            'attempt.login' => $this->attemptLogin()
        };
    }

    /**
     * Validate Rules for Attempt Login Request
     */
    public function attemptLogin()
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string',
            'remember' => 'nullable|in:on'
        ];
    }
}
