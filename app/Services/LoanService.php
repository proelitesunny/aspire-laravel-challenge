<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Transaction;

class LoanService{

    public function enquiry(){
        $response = [];
        $response['max_loan_amount'] = config('constants.max_loan_amount');
        $response['max_tenure'] = config('constants.max_tenure');
        $response['interest_rates'] = config('constants.interest_rates');

        return $response;
    }

    public function store($user, $amount, $tenure){
        $interestRates = config('constants.interest_rates');
        $rate = 0;
        foreach($interestRates as $interestRate){
            if ($tenure >= $interestRate['from'] && $tenure <= $interestRate['to']) {
                $rate = $interestRate['rate'];
                break;
            }
        }
        $loan = Loan::create([
            'user_id' => $user->id,
            'tenure' => $tenure,
            'amount' => $amount,
            'interest_rate' => $rate
        ]);
        return $this->getLoanDetails($loan);
    }

    public function show($loadId){
        $loan = Loan::findOrFail($loadId);
        return $this->getLoanDetails($loan);
    }

    public function getLoanDetails($loan){
        $response = [];
        $response['interest_rate'] = $loan->interest_rate;
        $response['tenure'] = $loan->tenure;
        $response['amount'] = $loan->amount;
        $response['final_payment_date'] = date('Y-m-d', strtotime($loan->created_at . '+ ' . $loan->tenure * 7 . ' days' ));
        $interestAmount = bcdiv(bcmul($loan->amount, bcmul($loan->interest_rate, $loan->tenure, 2), 2), 5200);
        $response['final_amount'] = bcadd($loan->amount, $interestAmount, 2);
        $response['weekly_payment_amount'] = bcdiv($response['final_amount'], $loan->tenure, 2);

        $transactions = Transaction::where('loan_id', $loan->id)->get();
        $paidAmount = $transactions->sum('amount');
        $response['balance_amount'] = bcsub($response['final_amount'], $paidAmount, 2);
        $response['transactions'] = $transactions;

        return $response;
    }

    public function pay($loanId, $amount){
        $loan = Loan::findOrFail($loanId);
        Transaction::create(['amount' => $amount, 'loan_id' => $loan->id]);
        return $this->getLoanDetails($loan);
    }
}
