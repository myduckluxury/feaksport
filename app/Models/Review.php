<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'rating', 'title', 'comment', 'status','order_id','product_variant_id','images'];
    protected $casts = [
        'images' => 'array', // Chuyển đổi cột images thành array khi lấy ra
    ];
    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
    public function orderItem()
    {
        return $this->hasOne(OrderItem::class, 'product_variant_id', 'product_variant_id')
            ->where('order_id', $this->order_id);
    }
}






























