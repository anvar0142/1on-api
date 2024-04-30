<?php

namespace App\Modules\BusinessDashboard\Employee\Dto;

use Illuminate\Support\Facades\Hash;

class CreateEmployeeDto
{
    public int $id;
    public string $username;
    public string $password;
    public string $phone;
    public string $email;
    public string $full_name;
    public string $organization_id;
    public string $profile_photo;
    public int|null $branch_id;
    public string $enabled;

    public function __construct($request)
    {
        $this->username = $request['username'];
        $this->password = Hash::make($request['password']);
        $this->phone = $request['phone'];
        $this->email = $request['email'];
        $this->full_name = $request['full_name'];
        $this->profile_photo = $request['profile_photo'] ??  '';
        $this->organization_id = $request['organization_id'];
        $this->branch_id = $request['branch_id'] ?? null;
    }
}
