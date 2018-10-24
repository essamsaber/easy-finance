<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Income;
use App\SourceOfIncome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class IncomeController extends Controller
{
    protected $limit = 15;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $income =  $request->user()->income()->paginate($this->limit);
        return view('income.index', compact('income'));
    }

    public function create()
    {
        $sources = SourceOfIncome::latest()->mine()->get();
        return view('income.create', compact('sources'));
    }

    public function store(AddIncomeRequest $request)
    {
        return $request->storeIncome();
    }

    public function edit(Income $income)
    {
        $this->authorize('edit', $income);
        $sources = auth()->user()->sources;
        return view('income.edit', compact('income', 'sources'));
    }

    public function update(UpdateIncomeRequest $request, Income $income)
    {
        $this->authorize('update', $income);
        return $request->updateIncome($income);
    }

    public function destroy(Income $income)
    {
        $this->authorize('delete', $income);

        try{
           DB::transaction(function() use($income){
               $income->transaction()->delete();
               auth()->user()->wallet()->increment('balance', $income->actual_income);
               $income->delete();
           });
           return session()
               ->flash('success', 'Income has been deleted successfully');
       } catch (\Exception $exception) {
           return session()
               ->flash('failed', 'Something went wrong');
           dd($exception->getMessage());
       }
    }
}

