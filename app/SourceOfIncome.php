<?php

namespace App;

use App\Http\Traits\QueryScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SourceOfIncome extends Model
{
    use QueryScope;

    protected $fillable = ['user_id', 'name', 'description', 'period', 'income', 'average'];

}
