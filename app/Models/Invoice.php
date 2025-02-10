<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;


    protected $fillable = [
        'invoice_date',
        'representative_name',
        'receiver_name',
        'invoice_number',
        'total_before_tax',
        'total_tax',
        'total_after_tax',
        'extra_discount',
        'total_discount',
        'final_total',
        'type',
        'created_by',
        'supplier_id',
      

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stock()
    {
        return $this->belongsToMany(Stock::class,'invoice_details');
    }
}
