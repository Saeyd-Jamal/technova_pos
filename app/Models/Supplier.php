<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
   

    protected $fillable = [
        'name',
        'num_tax',
        'financial_category',
        'email',
        'phone_number',
        'address',
        'status',
    ];
}
