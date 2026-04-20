<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class loan extends Model
{
    protected $fillable = ['user_npm', 'loan_at', 'return_at'];

    protected function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_npm', 'npm');
    }

    protected function loan_details(): HasMany
    {
        return $this->hasMany(loan_detail::class);
    }
}
