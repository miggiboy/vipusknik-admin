<?php

namespace App\Http\Controllers;

use App\Models\City\City;
use App\Region;

class RegionsController extends Controller
{
    public function index()
    {
        $regions = Region::with('cities')->orderBy('name')->get();
        $cities = City::with('region')->orderBy('title')->get();

        return view('regions.index', compact('regions', 'cities'));
    }

    public function store()
    {
        $this->validate(request(), [ 'name' => 'required' ]);

        Region::create(request()->only('name'));

        return redirect()->route('regions.index');
    }
}
