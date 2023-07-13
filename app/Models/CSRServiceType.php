<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CSRServiceType extends Model
{
    use HasFactory;

    /**
     *  DB settings
     */
    protected $table = 'tb_csr_service_type';

    /**
     *  Model attributes
     */
    protected $fillable = [
        'uuid',
        'desc',
        'created_at',
        'updated_at',
        'suspend',
    ];

    /**
     *  A service type has many CSR
     */
    public function csr(): HasMany
    {
        return $this->hasMany(CSR::class);
    }
}
