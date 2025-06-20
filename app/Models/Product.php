<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'discount',
        'sku',
        'featured',
        'sales_count',
        'view'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function imageLists()
    {
        return $this->hasMany(ImageList::class, 'product_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
