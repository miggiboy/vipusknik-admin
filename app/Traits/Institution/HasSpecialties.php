<?php

namespace App\Traits\Institution;

use Illuminate\Http\Request;

use App\Models\Specialty\Specialty;

trait HasSpecialties
{
    /**
     * Determine if this insitution has specialty with given ID
     *
     * @param  integer $specialtyID
     * @param  integer $studyForm
     * @return boolean
     */
    public function hasSpecialty($specialtyID, $studyForm)
    {
        return (bool) $this->specialties()
            ->wherePivot('specialty_id', $specialtyID)
            ->wherePivot('form', $studyForm)
            ->count();
    }

    public function specialtyTypes()
    {
        if ($this->isA('college')) {
            return ['qualifications', 'specialties'];
        }

        return ['specialties'];
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class)->withPivot('study_price', 'study_period', 'form');
    }

    public function specialties_distinct()
    {
        return $this->belongsToMany(Specialty::class)
            ->where('type', 'specialty')
            ->groupBy('specialty_id');
    }

    /**
     * Use to fetch data only!
     * Don't for attaching data!
     */
    public function qualifications()
    {
        return $this
            ->belongsToMany(Specialty::class)
            ->where('type', 'qualification')
            ->withPivot('study_price', 'study_period', 'form');
    }

    public function qualifications_distinct()
    {
        return $this
            ->belongsToMany(Specialty::class)
            ->where('type', 'qualification')
            ->groupBy('specialty_id');
    }
}
