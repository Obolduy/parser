<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_name',
        'price',
        'old_price',
        'discount_percents',
        'original_link_id',
        'cutted_link_id'
    ];
}
