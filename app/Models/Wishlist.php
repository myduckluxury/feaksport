<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'wishlists';
    protected $fillable = [
        'user_id',
        'product_id',
    ];



    
    // Liên kết với User
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Liên kết với Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
}
