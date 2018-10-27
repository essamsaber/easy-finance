<?php
/**
 * Created by PhpStorm.
 * User: esam
 * Date: 10/28/2018
 * Time: 1:01 AM
 */

namespace App\Http\Traits;


use App\Expense;
use App\ExpenseItem;
use App\Income;
use App\SourceOfIncome;
use App\Transaction;
use App\Wallet;

trait UserUtilities
{
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

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function income()
    {
        return $this->hasMany(Income::class);
    }

    public function payment()
    {
        return $this->hasMany(Expense::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}