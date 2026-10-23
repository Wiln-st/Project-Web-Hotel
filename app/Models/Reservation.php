<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'customer_name',
        'phone',
        'check_in',
        'check_out',
        'total_price',
        'facilities',
        'status'
    ];

    protected $casts = [
        'facilities' => 'array',
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
