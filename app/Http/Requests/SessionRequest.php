<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class SessionRequest extends FormRequest
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
            'session.store' => $this->store(),
            'session.update' => $this->update()
        };
    }

    /**
     * Validate Rules for store Request
     */
    public function store()
    {
        return [
            'name' => [ 'required', 'string', 'max:30', Rule::unique('sessions')->whereNull('deleted_at') ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ];
    }

    /**
     * Validate Rules for update Request
     */
    public function update()
    {
        return [
            'name' => [ 'required', 'string', 'max:30', Rule::unique('sessions')->whereNull('deleted_at')->ignore($this->route('session')) ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ];
    }
}
