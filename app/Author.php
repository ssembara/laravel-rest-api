<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name'
    ];

    public function books()
    {
        return $this->belongsToMany(
            Book::class,
            'author_has_books',
            'author_id',
            'book_id'
        );
    }
}
