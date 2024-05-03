<?php

namespace App\Modules\Auth\Dto;

class GoogleLoginDto
{
    public string $email;
    public string $name;
    public bool $is_client;

    public function __construct($request)
    {
        $this->name = $request['name'];
        $this->email = $request['email'];
        $this->is_client = $request['is_client'] ?? false;
    }
}
