<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class _return extends Model
{
    protected $table = 'returns';
    protected $fillable = ['loan_detail_id', 'charge', 'amount'];

    protected function loan_detail(): HasMany
    {
        return $this->hasMany(loan_detail::class, 'loan_detail_id', 'id');
    }
}
