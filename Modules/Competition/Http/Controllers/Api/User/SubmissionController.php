<?php

namespace Modules\Competition\Http\Controllers\Api\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Competition\Entities\Submission;
use Modules\Competition\Entities\Category;
use Modules\Competition\Entities\Team;
use Modules\Competition\Requests\UpdateCompetitionRequest;

use Modules\Competition\Transformers\SubmissionResource;

class SubmissionController extends Controller
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
        // return auth()->user()->id;
        //     $team_id = Team::Where('user_id', auth()->user()->id)->get('id');
    
      //$submissions = Submission::where('team_id', )->where()latest()->get();
     //    $submissions = auth()->user()->teams; //->pivot()->get();
       $submissions = Submission::with('teams')->latest()->get();

        //  return   $submissions->load('categories');
         // return response()->json($submission);
          return SubmissionResource::collection($submissions);
  
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
         if (Submission::where('team_id', $request->team_id)->exists()) {
            return response()->json(['message' => 'Summission already done'], 400);
            // post with the same slug already exists
                // $submission=  Submission::where('team_id', $request->team_id)
                // ->update(['name' => $request->name],
                // ['description' => $request->description],
                // ['intership_open' => $request->intership_open],
                // ['submitted_at' => $request->submitted_at],
                // ['url' => $request->url],
                // ['repo_url' => $request->repo_url], 
                // ['document' => $request->document]);
         }
         else{
          
            $submission = Submission::create($request->all());

         }

     //   $competitions = auth()->user()->teams;

         return new SubmissionResource($submission);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Competition $submission)
    {
        return new SubmissionResource($submission);
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
    public function update(Request $request, Submission $submission)
    {
        //
        $params = $request->all();
        $params['user_id'] = $user->id;

        $submission->update($params);
        
        return new SubmissionResource($submission);
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
