<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use App\Traits\FailedValidationTrait;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
            'role.store' => $this->store(),
            'role.update' => $this->update()
        };
    }

    /**
     * Validate Rules for Store Role Request
     */
    public function store()
    {
        return [
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array'
        ];
    }

    /**
     * Validate Rules for Update Role Request
     */
    public function update()
    {
        return [
            'name' => 'required|string|unique:roles,name,'.$this->role,
            'permissions' => 'required|array'
        ];
    }
}
