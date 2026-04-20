<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['category'];

    protected function books(): HashMany
    {
        return $this->hasMany(Book::class);
    }
}
