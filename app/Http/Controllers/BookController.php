<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::paginate($request->limit);

        return response(['book' => new BookResource($books), 'message' => 'Retrieved successfully'], 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|min:3',
            'description' => 'required|string|min:3',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pages' => 'required|integer',
            'published_at' => 'required|string',
            'author' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        
        $bookImage = 'default.jpg';
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $bookImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $bookImage);
        }

        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->image = $bookImage;
        $book->pages = $request->pages;
        $book->published_at = $request->published_at;
        $book->save();

        $author = Author::findOrFail($request->author);
        $book->authors()->sync($author);

        return response(['book' => new BookResource($book), 'message' => 'Created successfully'], 200);
    }

    public function show($id)
    { }
}
