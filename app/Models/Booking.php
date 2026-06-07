<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
    'reference_number',
    'user_id',
    'vehicle_id',
    'driver_id',
    'date',
    'time',
    'destination',
    'purpose',
    'status'
];

public function vehicle()
{
    return $this->belongsTo(Vehicle::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
public function driver()
{
    return $this->belongsTo(Driver::class);
}
}
