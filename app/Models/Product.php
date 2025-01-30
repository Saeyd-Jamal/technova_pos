<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
   

    protected $fillable = [
        'name',
        'image',
        'description',
        'status',
        'created_by',
        'category_id'
        
    ];

    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }


    public function flavor()
    {
        return $this->hasMany(Flavor::class);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}
