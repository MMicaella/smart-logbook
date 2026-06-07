<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
    'item_name',
    'category',
    'brand_name',
    'serial_number',
    'quantity',
    'description',
    'department',
];
}