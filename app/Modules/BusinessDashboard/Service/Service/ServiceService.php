<?php

namespace App\Modules\BusinessDashboard\Service\Service;

use App\Models\Organization\OrganizationService;
use App\Modules\BusinessDashboard\Service\Dto\CreateServiceDto;
use App\Modules\BusinessDashboard\Service\Dto\UpdateServiceDto;

class ServiceService
{
    public function create(CreateServiceDto $dto): OrganizationService
    {
        $service = new OrganizationService();
        $service->name = $dto->name;
        $service->price = $dto->price;
        $service->organization_id = $dto->organization_id;
        $service->time = $dto->time;

        $service->save();
        return $service;
    }

    public function update(UpdateServiceDto $dto): OrganizationService
    {
        $service = OrganizationService::query()->find($dto->id);
        $service->name = $dto->name ?? $service->name;
        $service->price = $dto->price ?? $service->price;
        $service->organization_id = $dto->organization_id ?? $service->organization_id;
        $service->time = $dto->time ?? $service->time;
        $service->save();

        return $service->first();
    }

    public function delete(OrganizationService $service): void
    {
        $service->delete();
    }

}
