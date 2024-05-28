<?php

namespace App\Modules\Auth\Dto;

class SetPhoneDto
{
    public string $email;
    public string $phone;

    public function __construct($request)
    {
        $this->email = $request['email'];
        $this->phone = $request['phone'];
    }
}
