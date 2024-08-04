<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $projects = DB::connection('project')
            ->table('projects')
			->where('active', 1)			
			->orderBy('name', 'asc')			
            ->get();
		


        return view('pages.projects.index', [
            'projects' => $projects
        ]);
    }
		


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

		
		$project = DB::connection('project')->table('projects')->where('id', $id)->first();
        if ($project == null) {
            abort(404);
        }
		$plan = DB::connection('project')->table('plans')->where('project_id', $project->id)->get();
		$floor = DB::connection('project')->table('floors')->where('project_id', $project->id)->get();
		



        
        return view('pages.projects.show', [
            'project' => $project,
			'plan' => $plan,
			'floor' => $floor			
        
        ]);		
		
		


		
		
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
