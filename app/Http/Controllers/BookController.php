<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Http\Resources\BookResource;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::latest('created_at')->whereHas('authors')->with('authors');

        if ($request->title) {
            $books = $books->where('title', 'LIKE', '%' . $request->title . '%');
        }

        if ($request->author) {
            $books->whereHas('authors', function ($q) use ($request) {
                $q->where('authors.name', $request->author);
            });
        }

        if ($request->limit) {
            $books = $books->paginate($request->limit);
        } else {
            $books = $books->get();
        }

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

        $bookImage = '00-default-book.png';
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

    public function show(Book $book)
    {
        return response(['book' => new BookResource($book), 'message' => 'Retrieved successfully'], 200);
    }

    public function update(Book $book, Request $request)
    {
        // dd($request->getContent());
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

        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $bookImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $upload = $image->move($destinationPath, $bookImage);

            if ($upload) {
                $bookOldImage = $book->image;
                File::delete('image/' . $bookOldImage);
            }
        }

        $book->title = $request->title;
        $book->description = $request->description;
        $book->image = $bookImage;
        $book->pages = $request->pages;
        $book->published_at = $request->published_at;
        $book->save();
        return response(['book' => new BookResource($book), 'message' => 'Update successfully'], 200);;
    }

    public function destroy(Book $book)
    {
        try {
            $book->delete();
            $bookOldImage = $book->image;
            File::delete('image/' . $bookOldImage);
        } catch (\Throwable $th) {
            return response(['message' => $th]);
        }


        return response(['message' => 'Deleted']);
    }
}
