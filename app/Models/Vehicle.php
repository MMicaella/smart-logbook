<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// class Vehicle extends Model
// {
//     protected $fillable = [
//         'name',
//         'plate_number',
//         'type',
//         'status',
//     ];
// }

class Vehicle extends Model
{
    protected $fillable = [
        'name',
        'plate_number',
        'type',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}