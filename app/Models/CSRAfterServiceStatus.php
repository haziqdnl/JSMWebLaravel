<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CSRAfterServiceStatus extends Model
{
    use HasFactory;

    /**
     *  DB settings
     */
    protected $table = 'tb_csr_after_service_status';

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
     *  An after service status has many CSR
     */
    public function csr(): HasMany
    {
        return $this->hasMany(CSR::class);
    }
}
