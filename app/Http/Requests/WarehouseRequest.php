<?php

namespace App\Http\Requests;

use App\Models\Warehouse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WarehouseRequest extends FormRequest
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
            'title'      => 'required|string|max:255',
            'city'       => 'required|string|max:255',
            'address'    => 'required|string|max:255',
            'country_id' => 'required|integer|exists:countries,id',
            'code'       => [
                'required',
                'string',
                'max:5',
                Rule::unique('warehouses')->ignore($this->route('warehouse')?->id),
            ],
        ];
    }

//    public function messages(): array
//    {
//        return [
//
//        ];
//    }

    public function attributes(): array
    {
        return Warehouse::aliases();
    }
}
