<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Loan;

class LoanShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Loan::where(['user_id' => $this->user()->id, 'id' => $this->route('loan_id')])->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
