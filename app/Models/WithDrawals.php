<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WithDrawals extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'date_of_withdrawal',
        'discount_amoun',
        'currancy',
        'remarks',
        'discount_mechanism',
        'employee_id',
        
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
