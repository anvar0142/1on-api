<?php

namespace App\Modules\BusinessDashboard\Service\Dto;

class CreateServiceDto
{
    public int $id;
    public string $name;
    public string $price;
    public string $time;
    public string $organization_id;

    public function __construct($request)
    {
        $this->name = $request['name'];
        $this->price = $request['price'];
        $this->time = $request['time'];
        $this->organization_id = $request['organization_id'];
    }
}
