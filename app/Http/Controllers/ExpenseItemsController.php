<?php

namespace App\Http\Controllers;

use App\ExpenseItem;
use App\Http\Requests\AddNewExpenseItem;
use App\Http\Requests\UpdateExpenseItemRequest;
use Illuminate\Http\Request;

/**
 * Class ExpenseItemsController
 * @package App\Http\Controllers
 */
class ExpenseItemsController extends Controller
{

    /**
     * This prop is used to set the pagination limit per page
     *
     * @var int
     */
    protected $limit = 15;


    /**
     * ExpenseItemsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $items = ExpenseItem::latest()->mine()->paginate($this->limit);
        return view('expense_items.index',compact('items'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('expense_items.create');
    }


    /**
     * @param ExpenseItem $expenseItem
     * @return ExpenseItem
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(ExpenseItem $expenseItem)
    {
        $this->authorize('view', $expenseItem);
        return $expenseItem;
    }


    /**
     * @param AddNewExpenseItem $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddNewExpenseItem $request)
    {
        $request->user()->expenseItems()->create($request->all());
        return redirect()->route('expense-items.index')
            ->with('success', 'New expense item has been created successfully !');
    }


    /**
     * @param ExpenseItem $expenseItem
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(ExpenseItem $expenseItem)
    {
        $this->authorize('edit', $expenseItem);
        return view('expense_items.edit', compact('expenseItem'));
    }


    /**
     * @param UpdateExpenseItemRequest $request
     * @param ExpenseItem $expenseItem
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateExpenseItemRequest $request, ExpenseItem $expenseItem)
    {
        $this->authorize('update', $expenseItem);
        $expenseItem->update($request->except('user_id'));
        return redirect()->route('expense-items.index')
            ->with('success', 'The income source has been updated successfully !');
    }


    /**
     * @param ExpenseItem $expenseItem
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(ExpenseItem $expenseItem)
    {
        $this->authorize('delete', $expenseItem);
        if($expenseItem->delete()) {
            return session()
                ->flash('success', 'Expense item has been deleted successfully');
        }
        return session()->flash('failed', 'Something went wrong');
    }


}
