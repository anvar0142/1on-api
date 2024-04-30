<?php

namespace App\Modules\BusinessDashboard\OrganizationBranch\Dto;

class UpdateOrganizationBranchDto
{
    public int $id;
    public string $name;
    public int $organization_id;
    public string $address;
    public string $phone;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'] ?? null;
        $this->organization_id = $data['organization_id'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->phone = $data['phone'] ?? null;
    }
}
