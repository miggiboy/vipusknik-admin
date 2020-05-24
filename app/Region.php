<?php

namespace App;

use App\Models\Model;
use App\Models\City\City;

class Region extends Model
{
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
