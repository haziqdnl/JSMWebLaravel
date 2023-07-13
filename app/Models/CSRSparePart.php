<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CSRSparePart extends Model
{
    use HasFactory;

    /**
     *  DB settings
     */
    protected $table = 'tb_csr_spare_part';

    /**
     *  Model attributes
     */
    protected $fillable = [
        'uuid',
        'serial_no',
        'desc',
        'qty',
        'amount',
        'revision_level',
        'csr_id',
        'created_at',
        'updated_at',
    ];

    /**
     *  Each spare parts belongs to a CSR
     */
    public function csr(): BelongsTo
    {
        return $this->belongsTo(CSR::class);
    }
}
