<?php

namespace App\Modules\Order\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class StoreOrderRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'employee_id' => 'required|integer|exists:employees,id',
            'start_time' => 'required|date|date_format:Y-m-d H:i:s',
            'completed' => 'bool',
            'organization_id' => 'required|integer|exists:organizations,id',
            'branch_id' => 'integer|exists:organization_branches,id',
            'status' => 'int',
            'added_by' => 'int|required',
            'service_ids' => 'array',
            'client_info' => [
                'required',
                'array',
                'client_info.phone' => 'required',
                'client_info.full_name' => 'required',
            ],
        ];
    }
}
