<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Loan;
use App\Models\Transaction;
use App\Services\LoanService;

class LoanPayRequest extends FormRequest
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
        $loan = Loan::where('id', $this->route('loan_id'))->firstOrFail();
        $loanService = new LoanService();
        $loanDetails = $loanService->getLoanDetails($loan);
        $loanAmount = $loanDetails['final_amount'];

        $paidAmount = Transaction::where('loan_id', $this->route('loan_id'))->sum('amount');
        $duesAmount = bcsub($loanAmount, $paidAmount, 2);
        return [
            'amount' => 'required|numeric|max:' . $duesAmount,
        ];
    }
}
