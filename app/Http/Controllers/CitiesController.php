<?php

namespace App\Http\Controllers;

use App\Models\City\City;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all()->sortBy('title');
        return view('cities.index', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|unique:cities',
            'title_genitive' => 'required',
            'region_id' => 'required'
        ]);

        City::create(request(['title', 'title_genitive', 'region_id']));

        return back()->with('message', 'Город добавлен успешно');
    }

    public function update(City $city)
    {
        $this->validate(request(), [
            'region_id' => 'required',
        ]);

        $city->update(request()->only('region_id'));

        return back()->with('message', 'Город обновлен успешно');
    }
}
