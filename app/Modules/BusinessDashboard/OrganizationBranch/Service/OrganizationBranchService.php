<?php

namespace App\Modules\BusinessDashboard\OrganizationBranch\Service;

use App\Models\Organization\OrganizationBranch;
use App\Modules\BusinessDashboard\OrganizationBranch\Dto\CreateOrganizationBranchDto;
use App\Modules\BusinessDashboard\OrganizationBranch\Dto\UpdateOrganizationBranchDto;

class OrganizationBranchService
{
    public function create(CreateOrganizationBranchDto $dto): OrganizationBranch
    {
        $organizationBranch = new OrganizationBranch();
        $organizationBranch->name = $dto->name;
        $organizationBranch->organization_id = $dto->organization_id;
        $organizationBranch->address = $dto->address;
        $organizationBranch->phone = $dto->phone;
        $organizationBranch->save();

        return $organizationBranch;
    }

    public function update(UpdateOrganizationBranchDto $dto): OrganizationBranch
    {
        $organizationBranch = OrganizationBranch::query()->find($dto->id);
        $organizationBranch->name = $dto->name ?? $organizationBranch->name;
        $organizationBranch->organization_id = $dto->organization_id ?? $organizationBranch->organization_id;
        $organizationBranch->address = $dto->address ?? $organizationBranch->address;
        $organizationBranch->phone = $dto->phone ?? $organizationBranch->phone;
        $organizationBranch->save();

        return $organizationBranch->first();
    }

    public function delete(OrganizationBranch $organizationBranch): void
    {
        $organizationBranch->delete();
    }

}
