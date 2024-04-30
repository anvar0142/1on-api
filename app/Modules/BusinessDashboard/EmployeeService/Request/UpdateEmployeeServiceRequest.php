<?php

namespace App\Modules\BusinessDashboard\EmployeeService\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class UpdateEmployeeServiceRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer',
            'employee_id' => 'required|integer|exists:employees,id',
            'service_id' => 'required|integer|exists:organization_services,id',
            'price' => 'required|integer',
            'time' => 'required|integer',
        ];
    }
}
