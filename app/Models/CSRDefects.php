<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CSRDefects extends Model
{
    use HasFactory;

    /**
     *  DB settings
     */
    protected $table = 'tb_csr_defect';

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
     *  Each defects belongs to a CSR
     */
    public function csr(): BelongsTo
    {
        return $this->belongsTo(CSR::class);
    }
}
