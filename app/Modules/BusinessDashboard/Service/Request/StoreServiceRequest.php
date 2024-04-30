<?php

namespace App\Modules\BusinessDashboard\Service\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class StoreServiceRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'organization_id' => 'required|integer|exists:organizations,id',
            'price' => 'required|int',
            'time' => 'required|int'
        ];
    }
}
