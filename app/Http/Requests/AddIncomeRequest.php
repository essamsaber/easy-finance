<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AddIncomeRequest extends FormRequest
{
    protected $process_id = null;

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
                            ->whereUserId(auth()->id());
                    })
            ]
        ];
    }

    public function storeIncome()
    {
        try {
            DB::transaction(function () {
                $data = $this->except('_token');
                $income_date = Carbon::parse($this->income_date);
                $data['income_date'] = $income_date;

                $this->insertToIncomeTable($data)
                    ->updateBalance($data)
                    ->makeTransaction($data);

            });
            return redirect()->route('income.index')
                ->with('success', 'Income has been recorded successfully !');
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return back()->with('failed', 'Sorry something went wrong !');
        }
    }

    private function insertToIncomeTable($data)
    {
        $insert = $this->user()->income()->create($data);
        $this->process_id = $insert->id;
        return $this;
    }

    private function updateBalance($data)
    {
        $this->user()->wallet
            ->increment('balance', $data['actual_income']);
        return $this;
    }

    private function makeTransaction($data)
    {
        $this->user()->transactions()->create([
            'type' => 'income',
            'transaction_date' => $data['income_date'],
            'amount' => $data['actual_income'],
            'process_id' => $this->process_id
        ]);
        return true;
    }
}
