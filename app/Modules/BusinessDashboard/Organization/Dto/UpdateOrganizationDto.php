<?php

namespace App\Modules\BusinessDashboard\Organization\Dto;

class UpdateOrganizationDto
{
    public int $id;
    public string $name;
    public string $address;
    public string $phone;
    public string $email;

    public function __construct($request)
    {
        $this->id = $request['id'];
        $this->name = $request['name'];
        $this->address = $request['address'];
        $this->phone = $request['phone'];
        $this->email = $request['email'];
    }
}
