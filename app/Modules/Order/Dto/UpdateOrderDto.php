<?php

namespace App\Modules\Order\Dto;

class UpdateOrderDto
{
    public int $id;
    public int $employee_id;
    public string $start_time;
    public string $end_time;
    public bool $completed;
    public int $organization_id;
    public int $client_id;
    public int|null $branch_id;
    public int $status;

    public function __construct($request)
    {
        $this->id = $request['id'];
        $this->employee_id = $request['employee_id'];
        $this->start_time = $request['start_time'];
        $this->end_time = $request['end_time'];
        $this->completed = $request['completed'] ?? false;
        $this->organization_id = $request['organization_id'];
        $this->client_id = $request['client_id'];
        $this->branch_id = $request['branch_id'] ?? null;
        $this->status = $request['status'] ?? 0;
    }
}
