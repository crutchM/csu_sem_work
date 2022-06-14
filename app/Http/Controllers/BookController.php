<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\RoadMap;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function getAll(){
        return response([
            'books'=>Book::all()
        ]);
    }

    public function getByUser(Request $request){
        $book = DB::table('books')->where('author_id', '=', $request->input('id'))->get();
        if ($book==null){
            $book = DB::table('books')->where('redactor_id', '=', $request->input('id'))->get();
            if ($book == null){
                $book = DB::table('books')->where('illustrator_id', '=', $request->input('id'))->get();
            }
        }
        if($book == null){
            return response(['message'=>'not found']);
        }
        return response(['book'=> $book]);
    }

    public function getById(Request $request){
        $book = Book::find($request->input('id'));
        if ($book == null){
            return response(['message'=>'not found']);
        }

        return response(['book'=>$book]);
    }


    public function create(Request $request){
        $fields = $request->validate([
            'name' => 'string|unique',
            'content' => 'string',
            'illustrator_id'=> 'integer',
            'redactor_id'=>'integer',
        ]);

        $book = Book::create([
            'name' => $fields['name'],
            'content' => $fields['content'],
            'author_id'=> auth()->user()->id,
            'illustrator_id' => $fields['illustrator_id'],
            'redactor_id' => $fields['redactor_id']
        ]);

        RoadMap::create([
            'comment'=>'the book ' . $book->name . ' was created by ' . User::find(auth()->user()->id),
            'book_id'=>$book->id
        ]);

        return response(['book'=>$book]);
    }

    public function updateName(Request $request){
        $book = Book::find($request->input('book'));
        $oldName = $book->name;
        $book->update(['name'=>$request->input('name')]);
        RoadMap::create(
            [
                "comment" => "the book " . $oldName . " name changed to " . $request->input('name') . " by " . $this->getRole(),
                "book_id" => $request->input('book')
            ]
        );
        return response('success');
    }

    public function updateContent(Request $request){
        $book = Book::find($request->input('book'));
        $book->update(['content' => $book->content .' ' . $request->input('content')]);
        RoadMap::create([
            "comment" => "updated content by " . $this->getRole(),
            "book_id" => $request->input('book')
        ]);
    }

    protected function getRole(){
        return Role::find(auth()->user()->role_id)->name;
    }

    public function changeIllustrator(Request $request){
        $book = Book::find($request->input('book'));
        $book->update(['illustrator_id' => $request->input('illustrator')]);
        RoadMap::create([
            "comment" => "changed illustrator to " . User::find($request->input('illustrator')->name),
            "book_id" => $request->input('book')
        ]);

        return response(['message'=>'success']);
    }

    public function changeRedactor(Request $request){
        $book = Book::find($request->input('book'));
        $book->update(['redactor_id' => $request->input('redactor')]);
        RoadMap::create([
            "comment" => "changed redactor to " . User::find($request->input('redactor')->name),
            "book_id" => $request->input('book')
        ]);

        return response(['message'=>'success']);
    }


    public function delete(Request $request){
        $book = Book::find($request->input('id'));
        DB::table('road_maps')->where('book_id', '=', $request->input('id'))->delete();
        DB::table('books')->where('id', '=',$request->input('id'))->delete();
        return response([
            'message'=>'book '. $book->name . ' successfully deleted'
        ]);
    }
}
