<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    use HasFactory;

    /**
     *  DB settings
     */
    protected $table = 'tb_asset';

    /**
     *  Model attributes
     */
    protected $fillable = [
        'serial_no',
        'model',
        'location_desc',
        'type',
        'down_status',
        'branch_code',
        'created_at',
        'updated_at',
    ];

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
