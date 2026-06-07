<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;
use App\Models\Vehicle;

class Driver extends Model
{
    protected $fillable = [

        'name',
        'license_number',
        'contact_number',
        'status',

    ];

    /*
    |--------------------------------------------------------------------------
    | BOOKINGS
    |--------------------------------------------------------------------------
    */

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /*
    |--------------------------------------------------------------------------
    | VEHICLES
    |--------------------------------------------------------------------------
    */

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}