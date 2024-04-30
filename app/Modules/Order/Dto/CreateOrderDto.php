<?php

namespace App\Modules\Order\Dto;

class CreateOrderDto
{
    public int $id;
    public int $employee_id;
    public string $start_time;
    public bool $completed;
    public int $organization_id;
    public string $client_phone;
    public int|null $branch_id;
    public int $status;
    public int $added_by;
    public array $service_ids;
    public string $client_full_name;

    public function __construct($request)
    {
        $this->employee_id = $request['employee_id'];
        $this->start_time = $request['start_time'];
        $this->completed = $request['completed'] ?? false;
        $this->organization_id = $request['organization_id'];
        $this->branch_id = $request['branch_id'] ?? null;
        $this->status = $request['status'] ?? '0';
        $this->added_by = $request['added_by'];
        $this->service_ids = $request['service_ids'];
        $this->client_full_name = $request['client_info']['full_name'];
        $this->client_phone = $request['client_info']['phone'];
    }
}
