<?php

namespace App\Modules\BusinessDashboard\EmployeeService\Dto;

class CreateEmployeeServiceDto
{
    public int $id;
    public int $employee_id;
    public int $service_id;
    public int $price;
    public int $time;

    public function __construct($request)
    {
        $this->employee_id = $request['employee_id'];
        $this->service_id = $request['service_id'];
        $this->price = $request['price'];
        $this->time = $request['time'];
    }
}
