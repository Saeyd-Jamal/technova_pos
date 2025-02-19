<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'representative_name',
        'receiver_name',
        'total_before_tax',
        'total_tax',
        'total_after_tax',
        'discount_type',
        'discount_amount',
        'extra_discount',
        'total_discount',
        'final_total',
        'type',
        'supplier_id',
        'supplier_name',
        'status',
        'created_by',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function products()
    {
        return $this->belongsToMany(Stock::class,'invoice_details','invoice_id','stock_id')->withPivot([
            'quantity',
            'unit_price',
            'tax_rate',
            'discount_value',
            'final_price',
        ]);
    }
}
