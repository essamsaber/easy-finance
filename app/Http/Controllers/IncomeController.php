<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Income;
use App\SourceOfIncome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * Class IncomeController
 * @package App\Http\Controllers
 */
class IncomeController extends Controller
{

    /**
     * Limit the pagination results
     *
     * @var int
     */
    protected $limit = 15;


    /**
     * IncomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $income =  $request->user()->income()->paginate($this->limit);
        return view('income.index', compact('income'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $sources = SourceOfIncome::latest()->mine()->get();
        return view('income.create', compact('sources'));
    }


    /**
     * @param AddIncomeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddIncomeRequest $request)
    {
        return $request->storeIncome();
    }


    /**
     * @param Income $income
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Income $income)
    {
        $this->authorize('edit', $income);
        $sources = auth()->user()->sources;
        return view('income.edit', compact('income', 'sources'));
    }


    /**
     * @param UpdateIncomeRequest $request
     * @param Income $income
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateIncomeRequest $request, Income $income)
    {
        $this->authorize('update', $income);
        return $request->updateIncome($income);
    }


    /**
     * @param Income $income
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
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

