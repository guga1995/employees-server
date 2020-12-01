<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
            'first_name' => [$requiredIfStore, 'string'],
            'last_name' => [$requiredIfStore, 'string'],
            'email' => [
                $requiredIfStore,
                'email',
                Rule::unique('employees', 'email')
                    ->ignore($this->route('employee'))
            ],
            'phone' => [$requiredIfStore, 'string'],
            'company_id' => [$requiredIfStore, 'exists:companies,id'],
        ];
    }
}
