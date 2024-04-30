<?php

namespace App\Models\Organization\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property mixed|string $username
 * @property mixed|string $password
 * @property mixed|string $phone
 * @property mixed|string $email
 * @property mixed|string $full_name
 * @property mixed|string $organization_id
 * @property mixed|string $profile_photo
 * @property int|mixed|null $branch_id
 */
class Employee extends User implements JWTSubject
{
    use HasFactory, SoftDeletes;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
