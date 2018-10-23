<?php

namespace App\Http\Controllers;

use App\ExpenseItem;
use App\Http\Requests\AddNewExpenseItem;
use App\Http\Requests\UpdateExpenseItemRequest;
use Illuminate\Http\Request;

class ExpenseItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // This prop is used to set the pagination limit per page
    protected $limit = 15;

    public function index()
    {
        $items = ExpenseItem::latest()->mine()->paginate($this->limit);
        return view('expense_items.index',compact('items'));
    }
    public function create()
    {
        return view('expense_items.create');
    }
    public function store(AddNewExpenseItem $request)
    {
        $request->user()->expenseItems()->create($request->all());
        return redirect()->route('expense-items.index')
            ->with('success', 'New expense item has been created successfully !');
    }
    public function edit(ExpenseItem $expenseItem)
    {
        return view('expense_items.edit', compact('expenseItem'));
    }

    public function update(UpdateExpenseItemRequest $request, ExpenseItem $expenseItem)
    {
        $expenseItem->update($request->except('user_id'));
        return redirect()->route('expense-items.index')
            ->with('success', 'The income source has been updated successfully !');
    }

    public function destroy(ExpenseItem $expenseItem)
    {
        if($expenseItem->delete()) {
            return session()
                ->flash('success', 'Expense item has been deleted successfully');
        }
        return session()->flash('failed', 'Something went wrong');
    }
}
