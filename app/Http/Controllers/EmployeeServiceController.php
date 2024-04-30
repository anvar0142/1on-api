<?php

namespace App\Http\Controllers;

use App\Models\Organization\Employee\EmployeeService;
use App\Modules\BusinessDashboard\EmployeeService\Dto\CreateEmployeeServiceDto;
use App\Modules\BusinessDashboard\EmployeeService\Dto\UpdateEmployeeServiceDto;
use App\Modules\BusinessDashboard\EmployeeService\Request\StoreEmployeeServiceRequest;
use App\Modules\BusinessDashboard\EmployeeService\Request\UpdateEmployeeServiceRequest;
use App\Modules\BusinessDashboard\EmployeeService\Service\EmployeeServices;
use Symfony\Component\HttpFoundation\Response;

class EmployeeServiceController extends Controller
{
    public function __construct(protected EmployeeServices $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index($employee_id)
    {
        $services = EmployeeService::query()->where(['employee_id' => $employee_id])->get();
        return response()->json($services, Response::HTTP_CREATED);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeServiceRequest $request)
    {
        $dto = new CreateEmployeeServiceDto($request->validated());
        $service = $this->service->create($dto);
        return response()->json($service, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $organization_id, int $employee_id, EmployeeService $service)
    {
        return response()->json($service, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeServiceRequest $request)
    {
        $dto = new UpdateEmployeeServiceDto($request->validated());
        $service = $this->service->update($dto);
        return response()->json($service, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeService $employeeService)
    {
        $this->service->delete($employeeService);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
