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
        $request->storeIncome();
    }

    public function edit(Income $income)
    {

        $sources = auth()->user()->sources;
        return view('income.edit', compact('income', 'sources'));
    }

    public function update(UpdateIncomeRequest $request, Income $income)
    {
        return $request->updateIncome($income);
    }
}

