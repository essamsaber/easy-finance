<?php

namespace App;

use App\Http\Traits\QueryScope;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use QueryScope;
    protected $guarded = ['id'];
    protected $dates = ['transaction_date'];
}
