<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\RoadMap;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class BookController extends Controller
{
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

    private function getRole(){
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
}
