<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'room_id',
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

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
