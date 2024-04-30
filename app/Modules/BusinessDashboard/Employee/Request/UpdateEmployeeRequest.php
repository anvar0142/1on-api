<?php

namespace App\Modules\BusinessDashboard\Employee\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'int|required',
            'username' => 'required|string|max:255',
            'organization_id' => 'required|integer|exists:organizations,id',
            'password' => 'required|string',
            'phone' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('organizations')->ignore($this->route('organization')),
            ],
            'full_name' => 'required|string',
            'profile_photo' => 'string|nullable',
        ];
    }
}
