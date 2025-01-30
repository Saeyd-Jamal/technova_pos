<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;
   

    protected $fillable = [
        'producy_id',
        'flavor_id',
        'size_id',
        'quantity_type_id',
        'quantity',    
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }


    public function flavor()
    {
        return $this->belongsTo(Flavor::class)->withDefault();
    }

    public function size()
    {
        return $this->belongsTo(Size::class)->withDefault();
    }

    public function quantity()
    {
        return $this->belongsTo(QuantityType::class)->withDefault();
    }
}
