<?php

namespace App\Models\City;

use App\Models\Model;
use App\Region;

class City extends Model
{
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
