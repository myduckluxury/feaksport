<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status', 
        'total', 
        'payment_method', 
        'payment_status',
        'address', 
        'fullname', 
        'email', 
        'phone_number', 
        'note',
        'total_final',
        'discount_amount',
        'shipping',
        'order_code',
        'reason_cancel',
        'reason_failed',
        'reason_returned',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function reason() {
        return $this->hasOne(Reason::class);
    }
}
