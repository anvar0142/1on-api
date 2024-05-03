<?php

namespace App\Modules\Auth\Dto;

class GoogleLoginDto
{
    public string $email;
    public string $name;
    public bool $is_client;

    public function __construct($request)
    {
        $this->code = $request['code'];
        $this->is_client = $request['is_client'] ?? false;
    }
}
