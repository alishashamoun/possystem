<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;
    protected $table = 'payment_details';

    protected $fillable = [
        'customer_id',
        'sale_id',
        'received_amount',
        'paying_amount',
        'change_return',
        'payment_gateway_transaction_id',
    ];



    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

}
