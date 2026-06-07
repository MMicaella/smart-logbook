<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Borrow extends Model
{
    protected $fillable = [
        'reference_number',
        'user_id',
        'item_id',
        'quantity',
        'purpose',
        'status',
        'borrow_date',
        'department',
        'approved_by',
        'approved_at',
        'expires_at',
        'qr_code',
        'return_status',
        'returned_at',
        'borrow_location',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'expires_at' => 'datetime',
        'borrow_date' => 'datetime',
        'returned_at' => 'datetime',
        'serial_number' => 'array',
    ];

    // USER RELATION
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ITEM RELATION
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // CHECK IF QR EXPIRED
    public function getIsExpiredAttribute()
    {
        return $this->expires_at &&
               Carbon::now()->greaterThan($this->expires_at);
    }
}