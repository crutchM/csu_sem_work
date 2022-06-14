<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function getAllUsers(){
        return response(['users'=>User::all()]);
    }

    public function delete(Request $request){
        DB::table('books')->where('author_id', '=', $request->input('id'));
        $user = User::find($request->input('id'));
        DB::table('users')->delete($request->input('id'));
        return response([
            'message'=>'user '. $user->name . ' successfully deleted'
        ]);
    }

    public function deleteIllustrator(Request $request){
        DB::table('books')->where('illustrator_id', '=', $request->input('id'));
        $user = User::find($request->input('id'));
        DB::table('users')->delete($request->input('id'));
        return response([
            'message'=>'user '. $user->name . ' successfully deleted'
        ]);
    }

    public function deleteRedactor(Request $request){
        DB::table('books')->where('redactor_id', '=', $request->input('id'));
        $user = User::find($request->input('id'));
        DB::table('users')->delete($request->input('id'));
        return response([
            'message'=>'user '. $user->name . ' successfully deleted'
        ]);
    }




    public function getAuthorWorks(Request $request){
        return response(['books'=>DB::table('books')->where('author_id', '=', $request->input('id'))->get()]);
    }
    public function getRedactorWorks(Request $request){
        return response(['books'=>DB::table('books')->where('redactor_id', '=', $request->input('id'))->get()]);
    }
    public function getIllustratorWorks(Request $request){
        return response(['books'=>DB::table('books')->where('illustrator_id', '=', $request->input('id'))->get()]);
    }
}
