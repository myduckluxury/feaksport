<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id', 
        'color', 
        'size', 
        'price', 
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItem() {
        return $this->hasMany(OrderItem::class);
    }
}
