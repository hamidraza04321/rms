<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class SettingsRequest extends FormRequest
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
            'settings.update.logo' => $this->updateLogo()
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
}
