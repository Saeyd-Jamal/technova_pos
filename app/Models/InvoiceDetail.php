<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceDetail extends Model
{
    use HasFactory;
   

    protected $fillable = [
        'quantity',
        'unit_price_before_tax',
        'tax_rate',
        'tax_amount',
        'unit_price_after_tax',
        'total_price_before_tax',
        'total_price_after_tax',
        'discount_amount',
        'final_price',
        'invoice_id',
        'stock_id',
    ];

}
