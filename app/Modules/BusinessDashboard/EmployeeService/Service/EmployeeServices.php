<?php

namespace App\Modules\BusinessDashboard\EmployeeService\Service;

use App\Models\Organization\Employee\EmployeeService;
use App\Modules\BusinessDashboard\EmployeeService\Dto\CreateEmployeeServiceDto;
use App\Modules\BusinessDashboard\EmployeeService\Dto\UpdateEmployeeServiceDto;

class EmployeeServices
{

    public function create(CreateEmployeeServiceDto $dto)
    {
        $employeeService = new EmployeeService();
        $employeeService->employee_id = $dto->employee_id;
        $employeeService->service_id = $dto->service_id;
        $employeeService->price = $dto->price;
        $employeeService->time = $dto->time;
        $employeeService->save();

        return $employeeService;
    }

    public function update(UpdateEmployeeServiceDto $dto)
    {
        $employeeService = EmployeeService::query()->find($dto->id);
        $employeeService->employee_id = $dto->employee_id;
        $employeeService->service_id = $dto->service_id;
        $employeeService->price = $dto->price;
        $employeeService->time = $dto->time;
        $employeeService->save();

        return $employeeService;
    }

    public function delete(EmployeeService $employeeService)
    {
        $employeeService->delete();
    }
}
