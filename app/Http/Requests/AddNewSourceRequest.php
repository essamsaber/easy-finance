<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddNewSourceRequest extends FormRequest
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
        $self = $this;
        return [
            'name' => [
                'required','max:255',
                Rule::unique('source_of_incomes')
                    ->where(function($query) use($self){
                        return $query
                            ->whereName($this->name)
                            ->whereUserId(auth()->id());
                    })
            ],
            'income' => 'required|numeric',
            'average' => 'required|numeric',
            'period' => 'in:yearly,monthly,weekly,daily'
        ];
    }
}