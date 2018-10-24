<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['expense_item_id','notes','expected_expense','actual_expense','expense_date'];
    protected $dates = ['expense_date'];
    protected $with = ['item'];

    public function item()
    {
        return $this->belongsTo(ExpenseItem::class,'expense_item_id', 'id');
    }

    public function getDateAttribute($value)
    {
        return $this->expense_date->format('Y-m-d');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'process_id')
            ->where('type', 'expense');
    }

}
