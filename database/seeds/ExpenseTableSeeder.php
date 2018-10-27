<?php

use Illuminate\Database\Seeder;

class ExpenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \Illuminate\Support\Facades\DB::table('expenses')->truncate();
        \Illuminate\Support\Facades\DB::table('transactions')
            ->where('type', 'expense')->delete();
        $user = \App\User::first() ?? factory(\App\User::class)->create();
        for($i = 0; $i < 7; $i++) {
            $sources = \App\ExpenseItem::latest()->get()->pluck('id')->toArray();
            $expense_item_id = rand(min($sources), max($sources));
            $expected_expense = rand(1000, 3500);
            $actual_expense = $expected_expense + rand(-100, 100);
            $expense_date = \Carbon\Carbon::today()->subMonths($i);
            // Insert to income table
            $payment = new \App\Expense();
            $payment->user_id = $user->id;
            $payment->expense_item_id = $expense_item_id;
            $payment->expected_expense = $expected_expense;
            $payment->actual_expense = $actual_expense;
            $payment->expense_date = $expense_date;
            $payment->save();
            // Make transaction
            $transaction = new \App\Transaction();
            $transaction->user_id = $user->id;
            $transaction->type = 'expense';
            $transaction->transaction_date = $expense_date;
            $transaction->amount = $actual_expense;
            $transaction->process_id = $payment->id;
            $transaction->save();
            // Update balance
            $user->wallet()->update(['balance' => $user->wallet->balance - $actual_expense ]);

        }
    }
}
