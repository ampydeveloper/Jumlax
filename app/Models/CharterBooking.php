<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CharterBookingPassengerDetail;
use App\Models\CharterPlaneFlightDetail;

class CharterBooking extends Model
{
    public function passengers()
    {
        return $this->hasMany(CharterBookingPassengerDetail::class);
    }
    public function charterDetails()
    {
        return $this->belongsTo(CharterPlaneFlightDetail::class, 'charter_plane_flight_details_id');
    }
}
