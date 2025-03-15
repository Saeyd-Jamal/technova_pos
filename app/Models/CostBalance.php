<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CostBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total_amount',
        'funds_statistics',
        'created_by'
    ];
}
