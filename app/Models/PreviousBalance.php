<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreviousBalance extends Model
{
    use HasFactory;


    protected $fillable = [
        'month',
        'amount',
        'type',
        
    ];
}
