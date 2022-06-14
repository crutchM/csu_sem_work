<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoadMapController extends Controller
{
    public function getByBook(Request $request){
        $map = DB::table('road_maps')->where('book_id', '=', $request->input('book'))->orderBy('id', 'desc')->get();
        if ($map == null){
            return response(['message'=>'this book hasn\'t a roadmap']);
        }
        return response(['road_map'=>$map]);
    }
}
