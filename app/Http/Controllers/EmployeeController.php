<?php

namespace App\Http\Controllers;

use App\Models\Organization\Employee\Employee;
use App\Models\Organization\Organization;
use App\Modules\BusinessDashboard\Employee\Dto\CreateEmployeeDto;
use App\Modules\BusinessDashboard\Employee\Dto\GetTimeSlotsDto;
use App\Modules\BusinessDashboard\Employee\Dto\UpdateEmployeeDto;
use App\Modules\BusinessDashboard\Employee\Request\GetTimeSlotsRequest;
use App\Modules\BusinessDashboard\Employee\Request\StoreEmployeeRequest;
use App\Modules\BusinessDashboard\Employee\Request\UpdateEmployeeRequest;
use App\Modules\BusinessDashboard\Employee\Service\EmployeeService;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function __construct(protected EmployeeService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $organization_id)
    {
        $employees = Employee::query()->where(['organization_id' => $organization_id])->get();
        return response()->json($employees, Response::HTTP_CREATED);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $dto = new CreateEmployeeDto($request->validated());
        $employee = $this->service->create($dto);
        return response()->json($employee, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Employee $employee)
    {
        return response()->json($employee, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request)
    {
        $dto = new UpdateEmployeeDto($request->validated());
        $employee = $this->service->update($dto);
        return response()->json($employee, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Employee $employee)
    {
        $this->service->delete($employee);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function getTimeSlots(Organization $organization, Employee $employee, GetTimeSlotsRequest $request)
    {
        $dto = new GetTimeSlotsDto($request->validated());
        $timeSlots = $this->service->getEmployeeTimeSlots($dto);
        return response()->json($timeSlots, Response::HTTP_OK);
    }
}
