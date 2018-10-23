<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSourceRequest extends FormRequest
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
            'name' =>'required','max:255',
            'income' => 'required|numeric',
            'average' => 'required|numeric',
            'period' => 'in:yearly,monthly,weekly,daily'
        ];
    }
}
