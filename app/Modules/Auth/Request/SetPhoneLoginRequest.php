<?php

namespace App\Modules\Auth\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class SetPhoneLoginRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required',
            'phone' => 'required',
        ];
    }
}
