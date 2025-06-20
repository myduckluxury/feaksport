<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method',
        'order_code',
        'address',
        'fullname',
        'email',
        'phone_number',
        'note',
        'total',
        'total_final', 
        'discount_amount', 
        'shipping'
    ];
}
