<?php

namespace App\Modules\Auth\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class LoginRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required',
            'is_client' => 'bool'
        ];
    }
}
