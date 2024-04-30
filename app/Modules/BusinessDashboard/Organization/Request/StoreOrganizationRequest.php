<?php

namespace App\Modules\BusinessDashboard\Organization\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => [
                'required',
                'regex:/^\+998(90|91|93|94|97|98|99|88)\d{7}$/'
            ],
            'email' => 'required|email|unique:organizations,email',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
          'name.required' => 'Name is required'
        ];
    }
}
