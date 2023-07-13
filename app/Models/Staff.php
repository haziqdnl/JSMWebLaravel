<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Staff extends Model
{
    use HasFactory;

    /**
     *  DB settings
     */
    protected $table = 'tb_staff';
    protected $primaryKey = 'uuid';

    /**
     *  Model attributes
     */
    protected $fillable = [
        'uuid',
        'email',
        'mobile_no',
        'fullname',
        'sex',          // 0 = Female; 1 = Male
        'birthdate',
        'address1',
        'address2',
        'postcode',
        'city',
        'state',
        'country',
        'created_at',
        'updated_at',
        'suspend',      // 0 = Active; 1 = Suspend
    ];

    /**
     *  Morph: Polymorphism relationship between Staff and User table
     */
    public function user(): MorphOne {  
        return $this->morphOne(User::class, 'profile');
    }

    /**
     *  A staff has many CSRs
     */
    public function csr(): HasMany {
        return $this->hasMany(CSR::class);
    }
}