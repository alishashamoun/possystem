<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'payment_status',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class,  'order_product')->withPivot('price');
    }

}
