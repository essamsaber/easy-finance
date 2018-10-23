<?php

namespace App;

use App\Http\Traits\QueryScope;
use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    use QueryScope;
    protected $fillable = ['user_id', 'name', 'description', 'period', 'requested_amount', 'average'];


}
