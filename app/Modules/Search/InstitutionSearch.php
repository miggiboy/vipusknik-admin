<?php

namespace App\Modules\Search;

use App\KeyboardLayoutConverter;
use App\Models\Institution\Institution;
use Illuminate\Http\Request;

class InstitutionSearch
{
    public static function applyFilters(Request $request)
    {
        $q = Institution::query();

        $q->ofType(
            $request->route('institutionType')
        );

        if ($request->has('query')) {
            $q->where(function ($q) {
                $q->like(request()->input('query'))
                    ->orWhere(function ($q) {
                        $q->like(
                            KeyboardLayoutConverter::convert(request()->input('query'))
                        );
                    });
            });
        }

        if ($request->has('city')) {
            $q->in($request->city);
        }

        if ($request->has('has_specialties')) {
            $q->has('specialties', (bool) $request->has_specialties);
        }

        if ($request->has('has_map')) {
            $q->has('map', (bool) $request->has_map);
        }

        if ($request->has('markers_of')) {
            $q->markedBy(request('markers_of'));
        }

        if ($request->has('is_paid')) {
            $q->isPaid($request->is_paid);
        }

        return $q;
    }
}
