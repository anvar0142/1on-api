<?php

namespace App\Modules\BusinessDashboard\Organization\Service;

use App\Models\Organization\Organization;
use App\Modules\BusinessDashboard\Organization\Dto\CreateOrganizationDto;
use App\Modules\BusinessDashboard\Organization\Dto\UpdateOrganizationDto;

class OrganizationService
{
    public function create(CreateOrganizationDto $dto): Organization
    {
        $organization = new Organization();
        $organization->name = $dto->name;
        $organization->email = $dto->email;
        $organization->phone = $dto->phone;
        $organization->address = $dto->address;

        $organization->save();
        return $organization;
    }

    public function update(UpdateOrganizationDto $dto): Organization
    {
        $organization = Organization::query()->find($dto->id)->first();
        $organization->name = $dto->name;
        $organization->email = $dto->email;
        $organization->phone = $dto->phone;
        $organization->address = $dto->address;

        $organization->save();
        return $organization;
    }

    public function delete(Organization $organization): void
    {
        $organization->delete();
    }
}
