<?php

namespace App\Modules\Order\Service;

use App\Models\Client;
use App\Models\Order;
use App\Models\Organization\OrganizationService;
use App\Modules\Order\Dto\ChangeOrderStatusDto;
use App\Modules\Order\Dto\CreateOrderDto;
use App\Modules\Order\Dto\UpdateOrderDto;
use App\Modules\Order\Event\OrderStatusChanged;
use Carbon\Carbon;
use App\Models\OrderService;

class OrdersService
{
    public function create(CreateOrderDto $dto): Order
    {
        $services = OrganizationService::query()->select(['time'])->whereIn('id', $dto->service_ids)->get()->map(function ($s) {
            return $s->time;
        })->toArray();
        $duration = array_sum($services);
        $dateTime = Carbon::createFromFormat('Y-m-d H:i:s', $dto->start_time)->addMinutes($duration)->format('Y-m-d H:i:s');

        $client = Client::query()->where(['phone' => $dto->client_phone])->first();
        if (!$client) {
            $client = new Client();
            $client->full_name = $dto->client_full_name;
            $client->phone = $dto->client_phone;
            $client->save();
        }

        $order = new Order();
        $order->client_id = $client->id;
        $order->organization_id = $dto->organization_id;
        $order->branch_id = $dto->branch_id;
        $order->status = $dto->status;
        $order->start_time = $dto->start_time;
        $order->end_time = $dateTime;
        $order->employee_id = $dto->employee_id;
        $order->added_by = $dto->added_by;
        if ($order->save()) {
            $order_id = $order->id;
            $insertData = array_map(function ($service_id) use ($order_id) {
                return [
                    'order_id' => $order_id,
                    'service_id' => $service_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $dto->service_ids);

            OrderService::query()->insert($insertData);
        }
        return $order;
    }

    public function update(UpdateOrderDto $dto): Order
    {
        $order = Order::query()->find($dto->id);
        $order->client_id = $dto->client_id;
        $order->organization_id = $dto->organization_id;
        $order->branch_id = $dto->branch_id ?? null;
        $order->status = $dto->status;
        $order->start_time = $dto->start_time;
        $order->end_time = $dto->end_time;
        $order->employee_id = $dto->employee_id;
        $order->save();

        return $order->get();
    }

    public function changeOrderStatus(ChangeOrderStatusDto $dto): Order
    {
        $order = Order::query()->find($dto->id);
        $order->status = $dto->status;
        $order->save();
        event(new OrderStatusChanged($order));
        return $order;
    }

    public function getAll(int $organization_id)
    {
        return Order::query()->where(['organization_id' => $organization_id])->with(['client', 'employee'])->get();
    }
}
