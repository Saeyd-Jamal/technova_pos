<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flavor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'image',
        'product_id'
        
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }


}
