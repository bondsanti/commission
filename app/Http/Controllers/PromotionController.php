<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\sub_team;
use Session;
use DB;
use Auth;


class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *promotions
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $projects = DB::connection('project')
            ->table('projects')
            ->get();

        foreach ($projects as $key => $project) {
			if (Auth::user()->role()->name == 'Admin') {				
            $project->promotions = DB::connection('project')
                ->table('promotions')
                ->where('expire', '>=', date('Y-m-d'))
                ->where('project_id', $project->id)
                ->get();
			}else
			{
			if (Auth::user()->role()->IN == 1)
			{
            $project->promotions = DB::connection('project')
                ->table('promotions')
                ->where('expire', '>=', date('Y-m-d'))
                ->where('project_id', $project->id)
				->whereIn('show_channel', ['0', '1'])				
                ->get();				
			}else{
            $project->promotions = DB::connection('project')
                ->table('promotions')
                ->where('expire', '>=', date('Y-m-d'))
                ->where('project_id', $project->id)
				->whereIn('show_channel', ['0', '2'])				
                ->get();								
			}
			}





        }
        return view('pages.promotions.index', [
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
        return view('pages.news.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promotion = DB::connection('project')->table('promotions')->where('id', $id)->first();
        if ($promotion == null) {
            abort(404);
        }
        $promotions = DB::connection('project')->table('promotions')->where('created_at', '>', date('Y-m-d'))->InRandomOrder()->limit(4)->get();
        return view('pages.promotions.show', [
            'promotion' => $promotion,
            'promotions' => $promotions
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
        $new = News::Find($id);
        $new->delete();
        Session::flash('status', 'Success');
        return redirect()->back();
    }
}