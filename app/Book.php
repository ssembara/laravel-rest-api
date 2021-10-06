<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function authors()
    {
        return $this->belongsToMany(
            Author::class,
            'author_has_books',
            'book_id',
            'author_id'
        );
    }
}
