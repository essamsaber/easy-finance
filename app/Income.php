<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = ['source_id', 'notes', 'expected_income', 'income_date','actual_income'];
    protected $with = ['source'];
    protected $dates = ['income_date'];

    public function source()
    {
        return $this->belongsTo(SourceOfIncome::class,'source_id', 'id');
    }

    public function getDateAttribute($value)
    {
        return $this->income_date->format('Y-m-d');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'process_id')
            ->where('type', 'income');
    }

}
