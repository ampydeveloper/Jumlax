<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CharterPlanes;

class CharterPlaneFlightDetails extends Model
{
    public function planes()
    {
        return $this->belongsTo(CharterPlanes::class, 'plane_id', 'id');
    }
    public function bookings()
    {
        return $this->hasMany(CharterBooking::class,   'plan_id','plane_id');
    }
}
 