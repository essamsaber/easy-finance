<?php

use Illuminate\Database\Seeder;

class IncomeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \Illuminate\Support\Facades\DB::table('incomes')->truncate();
        \Illuminate\Support\Facades\DB::table('transactions')
            ->where('type', 'income')->delete();
        $user = \App\User::first() ?? factory(\App\User::class)->create();
        for($i = 0; $i < 10; $i++) {
            $sources = \App\SourceOfIncome::latest()->get()->pluck('id')->toArray();
            $source_id = rand(min($sources), max($sources));
            $expected_income = rand(1000, 3500);
            $actual_income = $expected_income + rand(-100, 100);
            $income_date = \Carbon\Carbon::today()->subMonths($i);
            // Insert to income table
            $income = new \App\Income();
            $income->user_id = $user->id;
            $income->source_id = $source_id;
            $income->expected_income = $expected_income;
            $income->actual_income = $actual_income;
            $income->income_date = $income_date;
            $income->save();
            // Make transaction
            $transaction = new \App\Transaction();
            $transaction->user_id = $user->id;
            $transaction->type = 'income';
            $transaction->transaction_date = $income_date;
            $transaction->amount = $actual_income;
            $transaction->process_id = $income->id;
            $transaction->save();
            // Update balance
            $user->wallet()->update(['balance' => $user->wallet->balance + $actual_income ]);

        }

    }
}
