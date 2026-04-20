<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $primaryKey = 'npm';
    protected $fillable = ['username', 'first_name', 'last_name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    public function loans(): HasMany
    {
        return $this->hasMany(loan::class, 'user_npm', 'npm');
    }

}
