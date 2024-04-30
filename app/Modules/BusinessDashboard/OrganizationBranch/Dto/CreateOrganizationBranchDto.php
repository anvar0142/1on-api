<?php

namespace App\Modules\BusinessDashboard\OrganizationBranch\Dto;

class CreateOrganizationBranchDto
{
    public $name;
    public $organization_id;
    public $address;
    public $phone;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->organization_id = $data['organization_id'];
        $this->address = $data['address'];
        $this->phone = $data['phone'];
    }
}
