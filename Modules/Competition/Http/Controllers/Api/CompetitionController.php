<?php

namespace Modules\Competition\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Competition\Entities\Competition;
use Modules\Competition\Entities\Category;
use Modules\Competition\Requests\UpdateCompetitionRequest;

use Modules\Competition\Transformers\CompetitionResource;


class CompetitionController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $all_competition = Category::with('competitions')->latest()->get();

        //  return   $competitions->load('categories');
         // return response()->json($competition);
          return CompetitionResource::collection($all_competition);
  
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Competition $all_competition)
    {
         
       return new CompetitionResource($all_competition);
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
