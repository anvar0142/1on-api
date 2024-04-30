<?php

namespace App\Modules\BusinessDashboard\Employee\Dto;

class GetTimeSlotsDto
{
    public string $day;
    public string $duration;

    public function __construct($request)
    {
        $this->day = $request['day'];
        $this->duration = $request['duration'];
    }
}
