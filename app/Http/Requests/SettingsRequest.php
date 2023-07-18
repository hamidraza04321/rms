<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationTrait;
use App\Traits\CustomValidationTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class SettingsRequest extends FormRequest
{
    use FailedValidationTrait,
        CustomValidationTrait;

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
            'settings.update.logo' => $this->updateLogo(),
            'settings.update' => $this->update()
        };
    }

    /**
     * Validate Rules for Update Logo Request
     */
    public function updateLogo()
    {
        return [
            'app_logo' => 'required|mimes:jpeg,jpg,png|max:500000'
        ];
    }

    /**
     * Validate Rules for Update Request
     */
    public function update()
    {
        return [
            'school_name' => 'nullable|string',
            'school_name_in_short' => 'nullable|string',
            'email' => 'nullable|email',
            'phone_no' => 'nullable|string|max:20',
            'current_session_id' => $this->sessionRule('nullable'),
            'date_format' => 'nullable|string',
            'date_format_in_js' => 'nullable|string',
            'school_address' => 'nullable|string'
        ];
    }
}
