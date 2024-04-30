<?php

namespace App\Modules\BusinessDashboard\EmployeeService\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class StoreEmployeeServiceRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'employee_id' => 'required|integer',
            'service_id' => 'required|integer',
            'price' => 'required|integer',
            'time' => 'required|integer',
        ];
    }
}
