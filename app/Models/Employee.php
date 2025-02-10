<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    
    use HasFactory;


    protected $fillable = [
        'name',
        'date_of_birth',
        'age',
        'date_work',
        'academic_degree',
        'specialization',
        'workplace',
        'salary',

    ];



    public function withdrawals()
    {
        return $this->hasMany(WithDrawals::class);
    }

    public function salariey()
    {
        return $this->hasMany(Salariey::class);
    }

    public function leave()
    {
        return $this->hasMany(Leave::class);
    }
}
