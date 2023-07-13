<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerBranch extends Model
{
    use HasFactory;

    /**
     *  DB settings
     */
    protected $table = 'tb_customer_branch';

    /**
     *  Model attributes
     */
    protected $fillable = [
        'code',
        'org_code',
        'address1',
        'address2',
        'postcode',
        'city',
        'state',
        'country',
        'created_at',
        'updated_at',
        'suspend',
    ];

    /**
     *  A branch has many customers
     */
    public function customer(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     *  A branch has many assets
     */
    public function asset(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    /**
     *  Each branch belongs to one organisation
     */
    public function customerOrganisation(): BelongsTo
    {
        return $this->belongsTo(CustomerOrganisation::class);
    }
}
