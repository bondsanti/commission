<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Session;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('pages.news.index', [
            'news' => News::orderBy('created_at', 'desc')->get()
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
    {
        $news = new News();
        $news->title = $request->title;
        $news->date = date('Y-m-d', strtotime(str_replace('/', '-',  $request->date) . ' - 543 years'));
        $news->content = str_replace("\r\n", '<br/>', $request->content);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('image', 'public');
            $path = str_replace('public', 'storage', $path);
            $news->image = config('app.url') . '/storage/' . $path;
        }

        $news->save();


        Session::flash('status', 'Success');

        return redirect()->route('news.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return view('pages.news.show', [
            'new' => News::findOrfail($id)
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
        return view('pages.news.edit', [
            'new' => News::findOrfail($id)
        ]);
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
        $news = News::find($id);
        $news->title = $request->title;
        $news->date = date('Y-m-d', strtotime(str_replace('/', '-',  $request->date) . ' - 543 years'));
        $news->content = str_replace("\r\n", '<br/>', $request->content);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('image', 'public');
            $path = str_replace('public', 'storage', $path);
            $news->image = config('app.url') . '/storage/' . $path;
        }

        $news->save();


        Session::flash('status', 'Success');

        return redirect()->route('news.index');
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
        return redirect()->route('news.index');
    }
}