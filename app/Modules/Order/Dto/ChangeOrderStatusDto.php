<?php

namespace App\Modules\Order\Dto;

class ChangeOrderStatusDto
{
    public int $id;
    public int $status;

    public function __construct($request)
    {
        $this->id = $request['id'];
        $this->status = $request['status'] ?? '0';
    }
}
