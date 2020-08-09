<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\Institution;
use Illuminate\Http\Request;

class RelatedInstitutionsController extends Controller
{
    public function create(Institution $institution)
    {
        $institutions = Institution::orderBy('title')->get();

        return view('institutions.related.create', compact('institution', 'institutions'));
    }

    public function store(Institution $institution)
    {
        $institution->relatedInstitutions()->attach(request()->related_institutions);

        return redirect()->route('institutions.show', [ $institution->type, $institution ]);
    }

    public function delete(Institution $institution)
    {
        $institution->relatedInstitutions()
            ->wherePivot('institution_id', request()->related_institution)
            ->detach();

        $institution->dependentInstitutions()
            ->wherePivot('related_institution_id', request()->related_institution)
            ->detach();

        return redirect()->route('institutions.show', [ $institution->type, $institution ]);
    }
}
