<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpenseItem;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class PaymentsController
 * @package App\Http\Controllers
 */
class PaymentsController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $payments =  request()->user()->payment()->get();
        return view('payments.index', compact('payments'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $items = ExpenseItem::mine()->get();
        return view('payments.create', compact('items'));
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
     * @param PaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PaymentRequest $request)
    {
        return $request->storePayment();
    }

    /**
     * @param Expense $payment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Expense $payment)
    {
        $this->authorize('edit', $payment);

        $items = ExpenseItem::mine()->get();
        return view('payments.edit', compact('items','payment'));
    }

    /**
     * @param UpdatePaymentRequest $request
     * @param Expense $payment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePaymentRequest $request, Expense $payment)
    {
        $this->authorize('update', $payment);

        return $request->updatePayment($payment);
    }

    /**
     * @param Expense $payment
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Expense $payment)
    {
        $this->authorize('delete', $payment);

        try{
            DB::transaction(function() use($payment){
                $payment->transaction()->delete();
                auth()->user()->wallet()->increment('balance', $payment->actual_expense);
                $payment->delete();
            });
            return session()
                ->flash('success', 'Payment has been deleted successfully');
        } catch (\Exception $exception) {
            return session()
                ->flash('failed', 'Sorry something went wrong');
            dd($exception->getMessage());
        }
    }
}
