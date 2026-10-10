<?php

namespace App\Http\Requests;

use App\Models\Auction;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AuctionRequest extends FormRequest
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
            'date_time'           => 'required|date|date_format:Y-m-d H:i:s|after_or_equal:today',
            'images'              => 'required|array',
            'url_invaluable'      => 'nullable|string|url|max:255',
            'url_saleroom'        => 'nullable|string|url|max:255',
            'url_bidsquare'       => 'nullable|string|url|max:255',
            'url_liveauctioneers' => 'nullable|string|url|max:255',

            'title'               => 'required|string|max:255',
            'description'         => 'required|string|max:25000',
            'text'                => 'nullable|string|max:25000',
            'terms'               => 'nullable|string|max:25000',
            'seo_title'           => 'nullable|string|max:255',
            'seo_keywords'        => 'nullable|string|max:255',
            'seo_description'     => 'nullable|string|max:2500',

//            'lots'     => 'nullable|string|max:2500',
//            'photo_lots'     => 'nullable|string|max:2500',
        ];
    }

    public function messages(): array
    {
        return [
            'files.max'     => 'Ви можете завантажити не більше :max файлів',
            'files.*.mimes' => 'Файл :input має бути одного з типів: :values',
            'files.*.max'   => 'Файл :input не повинен перевищувати :max кілобайт',
            'files.*.file'  => 'Завантажений файл має бути коректним файлом',
        ];
    }

    public function attributes(): array
    {
        return Auction::aliases();
    }
}
