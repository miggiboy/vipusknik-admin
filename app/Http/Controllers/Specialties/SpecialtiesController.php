<?php

namespace App\Http\Controllers\Specialties;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Subject\Subject;

use App\Models\Specialty\{
    SpecialtyDirection,
    Specialty
};

use App\Models\Institution\Institution;

use App\Http\Requests\Specialty\{
    SpecialtyFormRequest
};

use App\Modules\Search\{
    SpecialtySearch
};

class SpecialtiesController extends Controller
{
    /**
     * Throw 404 exception if institution type is not in
     * self::$instituionTypes array
     */
    public function __construct()
    {
        parent::__construct();

        abort_if(
            Institution::doesntHaveType(request()->route('institutionType')), 404
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, $institutionType)
    {
        $specialties = SpecialtySearch::applyFiltersTo('specialties', $request)
            ->with(['direction', 'markers'])
            ->orderBy('title')
            ->paginate(15);

        $directions = SpecialtyDirection::of($institutionType)
            ->orderBy('title')
            ->get();

        return view('specialties.index', compact('specialties', 'directions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($institutionType)
    {
        $subjects = $this->getProfileSubjects();

        $directions = SpecialtyDirection::of($institutionType)
            ->orderBy('title')
            ->get();

        return view('specialties.create', compact('subjects', 'directions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialtyFormRequest $request, $institutionType)
    {
        $specialty = Specialty::create(
            $request->except('subjects')
        );

        $specialty->subjects()->sync(
            array_filter($request->subjects)
        );

        return redirect()
            ->route('specialties.show', [$institutionType, $specialty]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($institutionType, Specialty $specialty)
    {
        $specialty->load(['subjects']);

        return view('specialties.show', compact('specialty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($institutionType, Specialty $specialty)
    {
        $specialty->load(['subjects']);

        $subjects = $this->getProfileSubjects();

        $directions = SpecialtyDirection::of($institutionType)
            ->orderBy('title')
            ->get();

        return view(
            'specialties.edit', compact('specialty', 'subjects', 'directions')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SpecialtyFormRequest $request, $institutionType, Specialty $specialty)
    {
        $specialty->update(
            $request->except('subjects')
        );

        $specialty->subjects()->sync(
            array_filter($request->subjects)
        );

        return redirect()
            ->route('specialties.show', [$institutionType, $specialty])
            ->withMessage('Специальность обновлена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $institutionType, Specialty $specialty)
    {
        $specialty->delete();

        return redirect()
            ->route('specialties.index', $institutionType)
            ->withMessage('Специальность удалена');
    }

    /**
     * Search methods
     */

    public function search(Request $request)
    {
        $specialties = Specialty::query();

        if ($request->has('query')) {
            $specialties->like($request->input('query'));
        }

        $specialties->orderBy('type');

        return view('specialties.index', compact('specialties'));
    }

    public function rtSearch(Request $request, $institutionType)
    {
        $specialties = Specialty::select('slug as url', 'title', 'code as description')
            ->getOnly('specialties')
            ->of($institutionType)
            ->like($request->input('query'))
            ->orderBy('title')
            ->get();

        $specialties = $specialties->each(function ($item, $key) use ($institutionType) {
            $item->url = config('app.url') . "/{$institutionType}-specialties/" . $item->url;
        });

        return response()->json(['results' => $specialties], 200);
    }

    private function getProfileSubjects()
    {
        return Subject::where('is_profile', true)
            ->whereNull('parent_id')
            ->orderBy('title')
            ->get();
    }
}
