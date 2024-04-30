<?php

namespace App\Modules\BusinessDashboard\OrganizationBranch\Request;

use App\Modules\BusinessDashboard\Core\Request\BaseTenantRequest;

class UpdateOrganizationBranchRequest extends BaseTenantRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'integer|required',
            'name' => 'sometimes|string|max:255',
            'organization_id' => 'required|integer|exists:organizations,id',
            'address' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:255'
        ];
    }
}
