<?php

namespace App\Modules\Auth\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class LogoutRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'is_client' => 'bool'
        ];
    }
}
