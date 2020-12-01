<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
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
     * @return array
     */
    public function rules()
    {
        $requiredIfStore = Rule::requiredIf($this->method() === 'POST');

        return [
            'name' => [
                $requiredIfStore,
                'string',
                Rule::unique('companies', 'name')
                    ->ignore($this->route('company'))
            ],
            'email' => [
                $requiredIfStore,
                'email',
                Rule::unique('companies', 'email')
                    ->ignore($this->route('company'))
            ],
            'logo' => [$requiredIfStore, 'image', 'dimensions:min_width=100,min_height=100'],
            'website' => [$requiredIfStore, 'string'],
        ];
    }
}
