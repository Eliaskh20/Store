<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'image'];


    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')
        ->withPivot('quantity','price')
        ->withTimestamps();
    }

    public function reviews(){
        return $this->belongsTo(Review::class, 'reviews')->withPivot('rate','comment');
    }

}
