<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OriginalLinks extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_id',
        'original_link'
    ];
}
