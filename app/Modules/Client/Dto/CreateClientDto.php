<?php

namespace App\Modules\Client\Dto;

class CreateClientDto
{
    public string $email;
    public string $name;

    public function __construct($request)
    {
        $this->email = $request['email'];
        $this->name = $request['name'];
    }
}
