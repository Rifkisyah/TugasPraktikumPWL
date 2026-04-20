<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class loan_detail extends Model
{
    protected $fillable = ['loan_id', 'book_id', 'is_return'];

    protected function books(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    protected function loan(): BelongsTo
    {
        return $this->belongsTo(loan::class, 'loan_id', 'id');
    }

    protected function return(): BelongsTo
    {
        return $this->belongsTo(_return::class, 'id', 'loan_detail_id');
    }
}
