<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'expense_item_id' => 'required|integer|exists:expense_items,id',
            'actual_expense' => 'required|numeric',
            'expense_date' => [
                'required',
                'date_format:Y-m-d',
                Rule::unique('expenses')
                    ->where(function ($query) {
                        return $query
                            ->whereExpenseDate($this->expense_date)
                            ->where('expense_item_id', $this->expense_item_id)
                            ->whereUserId(auth()->id());
                    })
            ]

        ];
    }

    public function storePayment()
    {
        try {
            DB::transaction(function () {
                $data = $this->except('_token');
                $expense_date = Carbon::parse($this->expense_date);
                $data['expense_date'] = $expense_date;

                $this->insertToPaymentTable($data)
                    ->updateBalance($data)
                    ->makeTransaction($data);

            });
            return redirect()->route('payment.index')
                ->with('success', 'Payment has been recorded successfully !');
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return back()->with('failed', 'Sorry something went wrong !');
        }
    }

    private function insertToPaymentTable($data)
    {
        $insert = $this->user()->payment()->create($data);
        $this->process_id = $insert->id;
        return $this;
    }

    private function updateBalance($data)
    {
        $this->user()->wallet
            ->decrement('balance', $data['actual_expense']);
        return $this;
    }

    private function makeTransaction($data)
    {
        $this->user()->transactions()->create([
            'type' => 'expense',
            'transaction_date' => $data['expense_date'],
            'amount' => $data['actual_expense'],
            'process_id' => $this->process_id
        ]);
        return true;
    }
}
