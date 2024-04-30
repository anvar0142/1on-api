<?php

namespace App\Modules\BusinessDashboard\Service\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class UpdateServiceRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'integer|required',
            'organization_id' => 'required|integer|exists:organizations,id',
            'name' => 'required|string|max:255',
            'price' => 'required|int',
            'time' => 'required|int'
        ];
    }
}
