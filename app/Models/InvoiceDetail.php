<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $table = 'invoice_details';

    protected $fillable = [
        'quantity',
        'unit_price',
        'tax_rate',
        'discount_value',
        'final_price',
        'invoice_id',
        'stock_id',
    ];

    // relations
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
