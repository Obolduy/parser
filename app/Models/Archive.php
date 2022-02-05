<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'former_sale_id',
        'archived_at',
        'original_link_id'
    ];

    public $timestamps = false;
}
