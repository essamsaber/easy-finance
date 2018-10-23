<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UpdateIncomeRequest extends FormRequest
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
            'source_id' => 'required|integer|exists:source_of_incomes,id',
            'actual_income' => 'required|numeric',
            'income_date' => [
                'required',
                'date_format:Y-m-d',
                Rule::unique('incomes')
                    ->where(function ($query) {
                        return $query
                            ->whereIncomeDate($this->income_date)
                            ->whereUserId(auth()->id())
                            ->whereNotIn('id', [$this->id]);

                    })
            ]
        ];
    }

    public function updateIncome($income)
    {
        try{
            DB::transaction(function()use($income){
                $data = $this->except('_token', '_method');
                $this->updateWallet($income, $data)
                ->updateIncomeRecord($income, $data)
                ->updateTransaction($income, $data);

            });
            return redirect()
                ->route('income.index')
                ->with('success', 'Income record has been updated successfully !');
        }catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    private function updateWallet($income, $data)
    {
        auth()->user()->wallet()->decrement('balance', $income->actual_income);
        auth()->user()->wallet()->increment('balance', $data['actual_income']);
        return $this;
    }

    private function updateIncomeRecord($income, $data)
    {
        $income->update($data);
        return $this;
    }

    private function updateTransaction($income, $data)
    {
        $income->transaction()->update(['amount' => $data['actual_income']]);
        return true;
    }
}
