<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UpdatePaymentRequest extends FormRequest
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
                            ->whereUserId(auth()->id())
                            ->whereNotIn('id', [$this->id]);
                        ;
                    })
            ]

        ];
    }

    public function updatePayment($payment)
    {
        try{
            DB::transaction(function()use($payment){
                $data = $this->except('_token', '_method');
                $this->updateWallet($payment, $data)
                    ->updatePaymentRecord($payment, $data)
                    ->updateTransaction($payment, $data);

            });
            return redirect()
                ->route('income.index')
                ->with('success', 'Income record has been updated successfully !');
        }catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    private function updateWallet($payment, $data)
    {
        auth()->user()->wallet()->increment('balance', $payment->actual_expense);
        auth()->user()->wallet()->decrement('balance', $data['actual_expense']);
        return $this;
    }

    private function updatePaymentRecord($payment, $data)
    {
        $payment->update($data);
        return $this;
    }

    private function updateTransaction($payment, $data)
    {
        $payment->transaction()->update(['amount' => $data['actual_expense']]);
        return true;
    }
}
