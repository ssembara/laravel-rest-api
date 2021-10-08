<?php

namespace App\Http\Controllers;

use App\Author;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::paginate($request->limit);

        return response(['author' => new AuthorResource($authors), 'message' => 'Retrieved successfully'], 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:3',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $author = new Author();
        $author->name = $request->name;
        $author->save();

        return response(['author' => new AuthorResource($author), 'message' => 'Created successfully'], 201);
    }

    public function show(Author $author)
    {
        return response(['author' => new AuthorResource($author), 'message' => 'Retrieved successfully'], 200);
    }

    public function update(Author $author, Request $request)
    {
        $rules = [
            'name' => 'required|string|min:3',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $author->update($request->all());
        return response(['author' => new AuthorResource($author), 'message' => 'Update successfully'], 200);
    }

    public function destroy(Author $author)
    {

        $author->delete();

        return response(['message' => 'Deleted']);
    }
}
