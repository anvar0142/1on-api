<?php

namespace App\Modules\Auth\Dto;

class LoginDto
{
    public string $username;
    public string $password;
    public bool $is_client;

    public function __construct($request)
    {
        $this->username = $request['username'];
        $this->password = $request['password'];
        $this->is_client = $request['is_client'] ?? false;
    }
}
