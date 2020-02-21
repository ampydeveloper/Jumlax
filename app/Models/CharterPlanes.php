<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CharterPlanes extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function charterDetails() {
        return $this->belongsTo(CharterDetails::class, 'charter_details_id', 'id');
    }
    public function flight_details() {
        return $this->hasMany(CharterPlaneFlightDetail::class, 'plane_id');
    }
    
}
