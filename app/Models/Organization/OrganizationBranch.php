<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property mixed|string $address
 * @property mixed|string $phone
 * @property mixed|string $name
 * @property mixed|string $organization_id
 */
class OrganizationBranch extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id',
        'name',
        'address',
        'phone',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected array $dates = ['deleted_at'];

    /**
     * Get the organization that owns the branch.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

}
