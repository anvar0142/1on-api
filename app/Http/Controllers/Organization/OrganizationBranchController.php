<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationBranch;
use App\Modules\BusinessDashboard\OrganizationBranch\Dto\CreateOrganizationBranchDto;
use App\Modules\BusinessDashboard\OrganizationBranch\Dto\UpdateOrganizationBranchDto;
use App\Modules\BusinessDashboard\OrganizationBranch\Request\StoreOrganizationBranchRequest;
use App\Modules\BusinessDashboard\OrganizationBranch\Request\UpdateOrganizationBranchRequest;
use App\Modules\BusinessDashboard\OrganizationBranch\Service\OrganizationBranchService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrganizationBranchController extends Controller
{
    public function __construct(protected OrganizationBranchService $organizationService)
    {
    }

    public function index(int $organization_id): JsonResponse
    {
        $branches = OrganizationBranch::query()->where(['organization_id' => $organization_id])->get();
        return response()->json($branches, Response::HTTP_OK);
    }

    public function store(StoreOrganizationBranchRequest $request, OrganizationBranchService $organizationService): JsonResponse
    {
        $dto = new CreateOrganizationBranchDto($request->validated());
        $organization = $organizationService->create($dto);
        return response()->json($organization, Response::HTTP_CREATED);
    }

    public function show($id, OrganizationBranch $branch): JsonResponse
    {
        return response()->json($branch, Response::HTTP_OK);
    }

    public function update(UpdateOrganizationBranchRequest $request, OrganizationBranchService $branchService)
    {
        $dto = new UpdateOrganizationBranchDto($request->validated());
        $organization = $branchService->update($dto);

        return response()->json($organization, Response::HTTP_OK);
    }

    public function destroy(OrganizationBranch $branch)
    {
        $this->organizationService->delete($branch);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
