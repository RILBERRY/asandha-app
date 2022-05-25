<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class islands extends Model
{
    use HasFactory;
    protected $fillable = [
        'islandName',
        'atoll',
        'country',
    ];
}
