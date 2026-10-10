<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is_admin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'role_id'    => 'required|integer|exists:roles,id',
            'email'      => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->route('user')?->id),
            ],
            'name'       => 'required|string|max:255',
            'phone'      => 'nullable|string|max:255',
            'password'   => 'nullable|string|min:8|max:255',
            'warehouses' => 'required_if:role_id,' . Role::STOREKEEPER . '|array|exists:warehouses,id',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return User::aliases();
    }
}
