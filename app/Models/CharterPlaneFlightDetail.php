<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CharterPlanes;

class CharterPlaneFlightDetail extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function planes()
    {
        return $this->belongsTo(CharterPlanes::class, 'plane_id', 'id');
    }
    public function booking_details() {
        return $this->hasMany(CharterBooking::class, 'charter_plane_flight_details_id');
    }
}
