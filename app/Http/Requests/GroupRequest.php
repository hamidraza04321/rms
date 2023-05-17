<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class GroupRequest extends FormRequest
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
            'group.store' => $this->store(),
            'group.update' => $this->update()
        };
    }

    /**
     * Validate Rules for store Request
     */
    public function store()
    {
        return [
            'name' => [ 'required', 'string', 'max:30', Rule::unique('groups')->whereNull('deleted_at') ]
        ];
    }

    /**
     * Validate Rules for update Request
     */
    public function update()
    {
        return [
            'name' => [ 'required', 'string', 'max:30', Rule::unique('groups')->whereNull('deleted_at')->ignore($this->group) ]
        ];
    }
}
