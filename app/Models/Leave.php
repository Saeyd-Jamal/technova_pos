<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory;


    protected $fillable = [
        'num_leave',
        'date_start',
        'date_end',
        'discount_mechanism',
        'duration_type',
        'amount',
        'remarks',
        'employee_id',

    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
