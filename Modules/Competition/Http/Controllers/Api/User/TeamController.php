<?php

namespace Modules\Competition\Http\Controllers\Api\User;

use Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Competition\Entities\Team;
use Modules\User\Entities\User;
use Modules\Competition\Transformers\TeamResource;

class TeamController extends Controller
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
     //  return  Auth::user();
        //$teams = Team::with('competitions')->Auth()->latest()->get();
        $teams = Team::all();
        //  return   $competitions->load('categories');
         // return response()->json($competition);
         
          return TeamResource::collection($teams);
  
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('Team::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
      //  $user=1;
       // return $user->teams()->get();
        $team = Team::create($request->all());
       // return $team->id;
       //  $user= $request->user_id;
      //  
      //  $user->teams()->attach($team->id);
        DB::insert('insert into team_user (user_id, team_id) values (?, ?)', [$request->user_id, $team->id]);
    
        return new TeamResource($team);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('Team::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('Team::edit');
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
