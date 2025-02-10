<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salariey extends Model
{
    use HasFactory;


    protected $fillable = [
        'month',
        'fixed_salary',
        'total_discount',
        'final_salar',
        'employee_id',
        

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
