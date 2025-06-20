<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageReturn extends Model
{
    use HasFactory;
    public $fillable = [
        'reason_id',
        'image',
    ];
}
