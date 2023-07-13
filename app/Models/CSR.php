<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CSR extends Model
{
    use HasFactory;

    /**
     *  DB settings
     */
    protected $table = 'tb_csr';

    /**
     *  Model attributes
     */
    protected $fillable = [
        'uuid',
        'customer_id',
        'service_type',
        'service_type_other',
        'contract_type',
        'instruction_date',
        'report_desc',
        'asset_serial_no',
        'staff_id',
        'report_date',
        'service_desc',
        'service_date',
        'service_start_at',
        'service_end_at',
        'after_service_status',
        'charge_status',
        'charge_mileage',
        'charge_travel_hr',
        'charge_travel_min',
        'created_at',
        'updated_at',
    ];

    /**
     *  Each CSR belongs to a staff
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     *  Each CSR belongs to a customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     *  Each CSR belongs to an asset
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     *  Each CSR only own a contract type
     */
    public function csrContractType(): BelongsTo
    {
        return $this->belongsTo(CSRContractType::class);
    }

    /**
     *  Each CSR only own a service type
     */
    public function csrServiceType(): BelongsTo
    {
        return $this->belongsTo(CSRServiceType::class);
    }

    /**
     *  Each CSR only own a service type
     */
    public function csrAfterServiceStatus(): BelongsTo
    {
        return $this->belongsTo(CSRAfterServiceStatus::class);
    }

    /**
     *  A CSR has many remarks
     */
    public function csrRemarks(): HasMany
    {
        return $this->hasMany(CSRRemarks::class);
    }

    /**
     *  A CSR has many defects
     */
    public function csrDefects(): HasMany
    {
        return $this->hasMany(CSRDefects::class);
    }

    /**
     *  A CSR has many spare parts
     */
    public function csrSpareParts(): HasMany
    {
        return $this->hasMany(CSRSpareParts::class);
    }
}
