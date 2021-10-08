<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'pages', 'published_at'
    ];

    public function authors()
    {
        return $this->belongsToMany(
            Author::class,
            'author_has_book',
            'book_id',
            'author_id'
        );
    }
}
