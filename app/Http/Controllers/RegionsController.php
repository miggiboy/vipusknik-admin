<?php

namespace App\Http\Controllers;

use App\Region;

class RegionsController extends Controller
{
    public function index()
    {
        $regions = Region::with('cities')->get();

        return view('regions.index', compact('regions'));
    }

    public function store()
    {
        $this->validate(request(), [ 'name' => 'required' ]);

        Region::create(request()->only('name'));

        return redirect()->route('regions.index');
    }
}
