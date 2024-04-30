<?php

namespace App\Modules\BusinessDashboard\Employee\Dto;

use Illuminate\Support\Facades\Hash;

class UpdateEmployeeDto
{
    public int $id;
    public string $username;
    public string $password;
    public string $phone;
    public string $email;
    public string $full_name;
    public string $organization_id;
    public string|null $profile_photo;
    public string $enabled;
    public int|null $branch_id;

    public function __construct($request)
    {
        $this->id = $request['id'];
        $this->username = $request['username'];
        $this->password = Hash::make($request['password']);
        $this->phone = $request['phone'];
        $this->email = $request['email'];
        $this->full_name = $request['full_name'];
        $this->profile_photo = $request['profile_photo'] ?? '';
        $this->branch_id = $request['branch_id'] ?? null;
        $this->organization_id = $request['organization_id'];
    }
}
