<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SheetsDownloades extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'download_time',
        'download_count'
    ];
}
