<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkcutterTokens extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'setting_date'
    ];

    public $timestamps = false;
}