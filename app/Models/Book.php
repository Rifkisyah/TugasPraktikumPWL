<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'publisher', 'year', 'city', 'cover', 'bookshelf_id', 'category_id'];

    protected function bookshelf()
    {
        return $this->belongsTo(bookshelf::class);
    }

    protected function category()
    {
        return $this->belongsToMany(category::class);
    }

    protected function loan_details(): HasMany
    {
        return $this->hasMany(loan_detail::class, 'book_id', 'id');
    }

}
