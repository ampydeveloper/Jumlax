<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CharterPlaneFlightDetail;
use App\Models\CharterDetails;

class CharterPlane extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
