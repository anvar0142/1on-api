<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Modules\Order\Dto\ChangeOrderStatusDto;
use App\Modules\Order\Dto\CreateOrderDto;
use App\Modules\Order\Dto\UpdateOrderDto;
use App\Modules\Order\Request\ChangeOrderStatusRequest;
use App\Modules\Order\Request\StoreOrderRequest;
use App\Modules\Order\Request\UpdateOrderRequest;
use App\Modules\Order\Service\OrdersService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function __construct(protected OrdersService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $organization_id)
    {
        $orders = $this->service->getAll($organization_id);
        return response()->json($orders, Response::HTTP_CREATED);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $dto = new CreateOrderDto($request->validated());
        $order = $this->service->create($dto);
        return response()->json($order, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Order $order)
    {
        return response()->json($order, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request)
    {
        $dto = new UpdateOrderDto($request->validated());
        $order = $this->service->update($dto);
        return response()->json($order, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changeStatus(ChangeOrderStatusRequest $request)
    {
        $dto = new ChangeOrderStatusDto($request->validated());
        $order = $this->service->changeOrderStatus($dto);
        return response()->json($order, Response::HTTP_OK);
    }
}
