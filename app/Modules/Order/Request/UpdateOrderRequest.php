<?php

namespace App\Modules\Order\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class UpdateOrderRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'int|required',
            'employee_id' => 'required|integer|exists:employees,id',
            'start_time' => 'required|date|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date|date_format:Y-m-d H:i:s',
            'completed' => 'bool',
            'organization_id' => 'required|integer|exists:organizations,id',
            'branch_id' => 'integer|exists:organization_branches,id',
            'client_id' => 'required|integer|exists:clients,id',
            'status' => 'int',
        ];
    }
}
