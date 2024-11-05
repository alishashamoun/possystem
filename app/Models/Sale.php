<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $fillable = [
        'product_id',
        'customer_id',
        'warehouse',
        'status',
        'grand_total',
        'paid',
        'payment_status',
        'payment_type'
    ];

    public function getTotalAmountAttribute()
    {
        // Assuming you calculate the total amount based on other fields
        return $this->grand_total; // or some calculation
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_product')->withPivot('quantity', 'price')->withTimestamps();
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Sale.php
    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetail::class);
    }


}
