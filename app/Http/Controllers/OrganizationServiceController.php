<?php

namespace App\Http\Controllers;

use App\Models\Organization\OrganizationService;
use App\Modules\BusinessDashboard\Service\Dto\CreateServiceDto;
use App\Modules\BusinessDashboard\Service\Dto\UpdateServiceDto;
use App\Modules\BusinessDashboard\Service\Request\StoreServiceRequest;
use App\Modules\BusinessDashboard\Service\Request\UpdateServiceRequest;
use App\Modules\BusinessDashboard\Service\Service\ServiceService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrganizationServiceController extends Controller
{
    public function __construct(protected ServiceService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $organization_id)
    {
        $services = OrganizationService::query()->where(['organization_id' => $organization_id])->get();
        return response()->json($services, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $dto = new CreateServiceDto($request);
        $service = $this->service->create($dto);
        return response()->json($service, Response::HTTP_CREATED);
    }

    public function show($id, OrganizationService $service): JsonResponse
    {
        return response()->json($service, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request)
    {
        $dto = new UpdateServiceDto($request->validated());
        $service = $this->service->update($dto);
        return response()->json($service, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, OrganizationService $service)
    {
        $this->service->delete($service);
        return response()->json('Deleted successfully', Response::HTTP_OK);
    }
}
