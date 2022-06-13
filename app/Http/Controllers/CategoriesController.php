<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

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
}
