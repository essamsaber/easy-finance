<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function gravatar()
    {
        return asset('img/avatar.png');
    }

    public function sources()
    {
        return $this->hasMany(SourceOfIncome::class);
    }

    public function expenseItems()
    {
        return $this->hasMany(ExpenseItem::class);
    }
}
