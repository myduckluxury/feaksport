<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'admin_id',
        'action',
        'note',
        'changed_at'
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'admin_id');
    }

    protected $casts = [
        'changed_at' => 'datetime',
    ];
}
