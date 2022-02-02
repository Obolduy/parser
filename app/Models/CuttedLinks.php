<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuttedLinks extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_id',
        'cutted_link'
    ];
}
