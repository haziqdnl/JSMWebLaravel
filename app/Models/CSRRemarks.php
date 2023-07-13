<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CSRRemarks extends Model
{
    use HasFactory;

    /**
     *  DB settings
     */
    protected $table = 'tb_csr_remark';

    /**
     *  Model attributes
     */
    protected $fillable = [
        'uuid',
        'desc',
        'csr_id',
        'created_at',
        'updated_at',
    ];

    /**
     *  Each remarks belongs to a CSR
     */
    public function csr(): BelongsTo
    {
        return $this->belongsTo(CSR::class);
    }
}
