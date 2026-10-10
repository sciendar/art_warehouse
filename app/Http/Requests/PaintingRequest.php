<?php

namespace App\Http\Requests;

use App\Models\Painting;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaintingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ($this->user()?->is_admin() ?? false) || ($this->user()?->is_storekeeper() ?? false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'images'       => 'required_without:old_images|array',
            'images.*'     => 'nullable|file|image',
            'old_images'   => 'array',
            'old_images.*' => 'nullable|string',
            'title'        => 'nullable|string|max:255',
            'url'          => 'nullable|string|url|max:255',
            'track_number' => 'nullable|string|max:255',
            'description'  => 'nullable|string|max:25000',
            'condition'    => 'nullable|string|max:25000',
            'note'         => 'nullable|string|max:25000',
            'auction_id'   => 'nullable|int',
            'lot'          => 'nullable|int',
        ];
    }

    public function attributes(): array
    {
        return Painting::aliases();
    }
}
