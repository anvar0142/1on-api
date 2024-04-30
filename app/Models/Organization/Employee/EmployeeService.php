<?php

namespace App\Models\Organization\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int|mixed $employee_id
 * @property int|mixed $service_id
 * @property int|mixed $price
 * @property int|mixed $time
 */
class EmployeeService extends Model
{
    use HasFactory, SoftDeletes;
}
