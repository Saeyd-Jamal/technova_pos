<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
   

    protected $fillable = [
        'name',
        'qr_code',
        'image',
        'price',
        'description',
        'status',
        'created_by',
        'category_id'
    ];



    // Relationships
    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }


    public function flavors()
    {
        return $this->hasMany(Flavor::class);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}
