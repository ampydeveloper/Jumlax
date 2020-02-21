<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BookingPassengerDetails;

class Bookings extends Model
{
    public function passengers()
    {
        return $this->hasMany(BookingPassengerDetails::class, 'booking_id', 'id');
    }
}
