<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SourceOfIncome extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'period', 'income', 'average'];
}
