<?php

namespace App\Modules\BusinessDashboard\OrganizationBranch\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class StoreOrganizationBranchRequest extends BaseTenantRequest
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
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255'
        ];
    }
}
