<?php

namespace App\Modules\BusinessDashboard\Employee\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class StoreEmployeeRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|max:255',
            'organization_id' => 'required|integer|exists:organizations,id',
            'password' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'full_name' => 'required|string',
            'profile_photo' => 'string',
        ];
    }
}
