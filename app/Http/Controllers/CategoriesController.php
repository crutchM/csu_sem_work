<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function create(Request $request){
        Categories::create(["name"=>$request->input('name')]);
        return response([
            "message"=>"created"
        ]);
    }


    public function getAll(Request $request){
        return response([
            "categories" => Categories::all()
        ]);
    }

    public function delete(Request $request){
        DB::table('categories')->where('id', '=', $request->input('id'))->delete();
    }
}
