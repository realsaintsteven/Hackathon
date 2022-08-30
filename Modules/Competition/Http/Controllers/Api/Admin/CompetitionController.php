<?php

namespace Modules\Competition\Http\Controllers\Api\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Competition\Entities\Competition;
use Modules\Competition\Entities\Category;
use Modules\Competition\Requests\UpdateCompetitionRequest;

use Modules\Competition\Transformers\CompetitionResource;

class CompetitionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:view competition');
        // $this->middleware('permission:create competition', ['only' => ['create','store']]);
        // $this->middleware('permission:update competitiont', ['only' => ['edit','update']]);
        // $this->middleware('permission:delete competition', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // $competitions=Competition::all();
        $competitions = Category::with('competitions')->latest()->get();

      //  return   $competitions->load('categories');
       // return response()->json($competition);
        return CompetitionResource::collection($competitions);

       
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
     //   return view('competition::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $competition = Competition::create($request->all());
        // $competition->categories()->sync($request->categories);
        // $upload = $this->upload($request, $competition);

       // $competition->load('categories');

        return new CompetitionResource($competition);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Competition $competition)
    {
    // return   $competition->load('categories');
      //  $competition::with('categories', 'images', 'competitions');
        return new CompetitionResource($competition);
       // return view('competition::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('competition::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCompetitionRequest $request, Competition $competition)
    {
        //
       // return $request->all();
        $competition->update($request->all());
       // $competition->save();
    //   //  $upload = $this->upload($request, $competition);
        // $competition->with('categories', 'images');

        return new CompetitionResource($competition);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
