<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerOrganisation extends Model
{
    use HasFactory;

    /**
     *  DB settings
     */
    protected $table = 'tb_customer_organisation';

    /**
     *  Model attributes
     */
    protected $fillable = [
        'code',
        'desc',
        'sdesc',
        'created_at',
        'updated_at',
        'suspend',
    ];

    /**
     *  An Organisation has many branches
     */
    public function customerBranch(): HasMany
    {
        return $this->hasMany(CustomerBranch::class);
    }
}
