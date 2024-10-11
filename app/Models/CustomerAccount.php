<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Model
{
    use HasFactory;

    protected $table ='customer_accounts';
    protected $fillable = [
        'customer_id',
        'user_name',
        'password',
    ];
}
