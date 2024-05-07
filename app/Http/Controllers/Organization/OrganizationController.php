<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\Organization;
use App\Modules\BusinessDashboard\Organization\Dto\CreateOrganizationDto;
use App\Modules\BusinessDashboard\Organization\Dto\UpdateOrganizationDto;
use App\Modules\BusinessDashboard\Organization\Request\StoreOrganizationRequest;
use App\Modules\BusinessDashboard\Organization\Request\UpdateOrganizationRequest;
use App\Modules\BusinessDashboard\Organization\Service\OrganizationService;
use App\Modules\Client\Service\ClientService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrganizationController extends Controller
{

    public function __construct(protected ClientService $clientService)
    {
    }

    public function initOrganization(): JsonResponse
    {
        $domain = request()->getHost();
        $organization = Organization::where('domain', $domain)->first();

        if (!$organization) {
            return response()->json(['error' => 'Organization not found'], ResponseAlias::HTTP_NOT_FOUND);
        }

        return response()->json($organization, ResponseAlias::HTTP_OK);
    }

    public function index(): JsonResponse
    {
        return response()->json(Organization::all(), ResponseAlias::HTTP_OK);
    }

    public function store(StoreOrganizationRequest $request, OrganizationService $organizationService): JsonResponse
    {
        $dto = new CreateOrganizationDto($request->validated());
        $organization = $organizationService->create($dto);
        return response()->json($organization, ResponseAlias::HTTP_CREATED);
    }

    public function show(Organization $organization)
    {
        return response()->json($organization, ResponseAlias::HTTP_OK);
    }

    public function update(UpdateOrganizationRequest $request, $id, OrganizationService $organizationService)
    {
        $dto = new UpdateOrganizationDto(array_merge($request->validated(), ['id' => $id]));
        $organization = $organizationService->update($dto);

        return response()->json($organization, ResponseAlias::HTTP_OK);
    }

    public function destroy(Organization $organization, OrganizationService $organizationService)
    {
        $organizationService->delete($organization);

        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }



    public function checkClientPhone(Organization $organization, string $phone)
    {
        $client = $this->clientService->getClientByPhone($phone);
        return response()->json($client, ResponseAlias::HTTP_OK);
    }
}
