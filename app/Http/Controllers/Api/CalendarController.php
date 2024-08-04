<?php

namespace App\Http\Controllers\Api;;

use App\Models\Calendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{

    public function getData()
    {
        $calendar = Calendar::get();
        return response()->json($calendar);
    }

    public function postData(Request $request)
    {
        $calendar = new  Calendar;
        $calendar->title = $request->title;
        $calendar->from = $request->start;
        $calendar->to = $request->end;
        $calendar->save();
        return response()->json($calendar);
    }

    public function removeData(Request $reques, $id)
    {

        $calendar = Calendar::find($id);
        $calendar->delete();
        return response()->json('Success');
    }

    public function putData(Request $reques, $id)
    {
        $calendar = Calendar::find($id);
        $calendar->from = date('Y-m-d H:i', strtotime($reques->start));
        $calendar->to = date('Y-m-d H:i', strtotime($reques->end));
        $calendar->save();
        return response()->json($calendar);
    }
}