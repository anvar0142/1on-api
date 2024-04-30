<?php

namespace App\Modules\BusinessDashboard\Employee\Request;

use Illuminate\Foundation\Http\FormRequest;

class GetTimeSlotsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'day' => 'required|date|date_format:Y-m-d',
            'duration' => 'required|integer'
        ];
    }
}
