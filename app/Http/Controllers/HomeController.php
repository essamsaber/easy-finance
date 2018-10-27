<?php

namespace App\Http\Controllers;

use App\ExpenseItem;
use App\SourceOfIncome;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_year = Carbon::today()->year;

        $actual_income = $this->getMonthlyActualIncomeForTheCurrentYear($current_year);

        $actual_expense = $this->getMonthlyActualPaymentsForTheCurrentYear($current_year);

        $expected_expense_for_this_month = ExpenseItem::mine()->where('period', 'monthly')->sum('requested_amount');

        $expected_income_for_this_month = SourceOfIncome::mine()->where('period', 'monthly')->sum('income');

        return view('home')->with([
            'month_labels' => array_values(config('finance.months')),
            'monthly_income' => $this->getAmountForEachMonth($actual_income),
            'monthly_expense' => $this->getAmountForEachMonth($actual_expense),
            'expected_income' => $expected_income_for_this_month,
            'expected_expense' => $expected_expense_for_this_month,
            'balance' => auth()->user()->wallet->balance
        ]);
    }


    /**
     * Assign each amount to it's month
     *
     * @param $income
     * @return array
     */
    private function getAmountForEachMonth($income)
    {
        $income = $income->toArray();

        $array = [];

        foreach(config('finance.months') as $key => $value) {

            if(array_key_exists($key, $income)) {

                $array[] = $income[$key][0]['ammount'];
            } else {
                $array[] = null;
            }
        }
        return $array;
    }

    /**
     * Get the actual income for the current year
     *
     * @param $current_year
     * @return mixed
     */
    private function getMonthlyActualIncomeForTheCurrentYear($current_year)
    {
        $actual_income = Transaction::mine()->where('type', 'income')
            ->whereYear('transaction_date', $current_year)
            ->select(
                DB::raw('YEAR(transaction_date) year'),
                DB::raw('MONTH(transaction_date) month'),
                DB::raw('sum(amount) as ammount')
            )
            ->orderBy('transaction_date')
            ->groupBy(DB::raw('MONTH(transaction_date)'))
            ->get()->groupBy(function($row){
                return $row->month;
            });
        return $actual_income;
    }

    /**
     * Get the actual payments for the current year
     *
     * @param $current_year
     * @return mixed
     */
    private function getMonthlyActualPaymentsForTheCurrentYear($current_year)
    {
        $actual_expense = Transaction::mine()->where('type', 'expense')
            ->whereYear('transaction_date', $current_year)
            ->select(
                DB::raw('YEAR(transaction_date) year'),
                DB::raw('MONTH(transaction_date) month'),
                DB::raw('sum(amount) as ammount')
            )
            ->orderBy('transaction_date')
            ->groupBy(DB::raw('MONTH(transaction_date)'))
            ->get()->groupBy(function($row){
                return $row->month;
            });
        return $actual_expense;
    }


}
