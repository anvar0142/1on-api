<?php

namespace App\Modules\Order\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class ChangeOrderStatusRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer|exists:orders,id',
            'status' => 'int|required',
        ];
    }
}
