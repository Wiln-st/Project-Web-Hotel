<?php

namespace App\Models;

use App\Models\Reservation;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'room_type_id',
        'status',
    ];

    // public function reservations()
    // {
    //     return $this->hasMany(Reservation::class);
    // }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }

    public function getActiveReservationAttribute()
    {
        return $this->reservations()

            ->where('check_in', '<=', now())
            ->where('check_out', '>', now())

            ->latest()
            ->first();
    }
}
