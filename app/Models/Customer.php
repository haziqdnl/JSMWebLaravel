<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Customer extends Model
{
    use HasFactory;

    /**
     *  DB settings
     */
    protected $table = 'tb_customer';

    /**
     *  Model attributes
     */
    protected $fillable = [
        'uuid',
        'email',
        'mobile_no',
        'fullname',
        'branch_code',
        'created_at',
        'updated_at',
        'suspend',
    ];

    /**
     *  Morph: Polymorphism relationship between Staff and User table
     */
    public function user(): MorphOne {  
        return $this->morphOne(User::class, 'profile');
    }

    /**
     *  Each customer belongs to one branch
     */
    public function customerBranch(): BelongsTo
    {
        return $this->belongsTo(CustomerBranch::class);
    }

    /**
     *  A customer has many CSRs
     */
    public function csr(): HasMany
    {
        return $this->hasMany(CSR::class);
    }
}
