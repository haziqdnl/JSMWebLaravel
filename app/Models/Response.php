<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    /**
     *  Model attributes
     */
    protected $fillable = [
        'data',
        'code',
        'status',
        'message',
        'token'
    ];
}
