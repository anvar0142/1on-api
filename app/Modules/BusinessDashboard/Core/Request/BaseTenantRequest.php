<?php

namespace App\Modules\BusinessDashboard\Core\Request;

use Illuminate\Foundation\Http\FormRequest;

class BaseTenantRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'organization_id' => $this->route('organization'),
        ]);
    }
}
