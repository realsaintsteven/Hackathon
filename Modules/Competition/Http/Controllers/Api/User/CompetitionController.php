<?php

namespace Modules\Competition\Http\Controllers\Api\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Competition\Entities\Competition;
use Modules\Competition\Entities\Category;
use Modules\Competition\Entities\Team;
use Modules\Competition\Requests\UpdateCompetitionRequest;

use Modules\Competition\Transformers\CompetitionResource;

class CompetitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $competitions = auth()->user()->teams;
     //  $competitions = Team::auth()->latest()->get();
    //    $competitions = Team::with('competitions')->latest()->get();

         // return auth()->user()->id;
        // $competitions->load('categories');
         // return response()->json($competition);
          return CompetitionResource::collection($competitions);
  
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('competition::create');
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
 
         $competition->load('categories');
 
         return new CompetitionResource($competition);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Competition $competition)
    {
        return new CompetitionResource($competition);
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
    public function update(Request $request, $id)
    {
        //
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
