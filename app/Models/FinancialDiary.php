<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialDiary extends Model
{
    use HasFactory;


    protected $fillable = [
        'date',
        'day',
        'cash_inventory',
        'operating_cost',
        'net_income',
        'profit_percentage',
        'gross_profit',
        'remaining_profit',
        'daily_purchases',
        'daily_sales',
        'daily_tax_collected',
        'discount_given',
        'remarks',
        'created_by',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
