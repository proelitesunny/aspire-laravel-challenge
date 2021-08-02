<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Loan\LoanEnquiryRequest;
use App\Http\Requests\Loan\LoanStoreRequest;
use App\Http\Requests\Loan\LoanShowRequest;
use App\Http\Requests\Loan\LoanPayRequest;
use App\Http\Requests\Loan\LoanIndexRequest;
use App\Services\LoanService;

class LoanController extends Controller
{
    private $loan;

    public function __construct(LoanService $loan){
        $this->loan = $loan;
    }

    public function index(LoanIndexRequest $request){
        try{
            $user = $request->user();
            return [
                'message' => 'Success',
                'loans' => $this->loan->index($user)
            ];
        }
        catch(\Exception $e){
            logger()->error($e->getMessage());
            return response()->json(['message' => 'Some error occured'], 400);
        }
    }

    public function enquiry(LoanEnquiryRequest $request){
        try{
            return $this->loan->enquiry();
        }
        catch(\Exception $e){
            logger()->error($e->getMessage());
            return response()->json(['message' => 'Some error occured'], 400);
        }
    }

    public function store(LoanStoreRequest $request){
        try{
            $user = $request->user();
            $loanDetails = $this->loan->store($user, $request->get('amount'), $request->get('tenure'));

            return [
                'message' => 'You load has been successfully approved',
                'loan_details' => $loanDetails
            ];
        }
        catch(\Exception $e){
            logger()->error($e->getMessage(). $e->getFile() . $e->getLine());
            return response()->json(['message' => 'Some error occured'], 400);
        }
    }

    public function show(LoanShowRequest $request, $loadId){
        try{
            return [
                'message' => 'Success',
                'loan_details' => $this->loan->show($loadId),
            ];
        }
        catch(\Exception $e){
            logger()->error($e->getMessage(). $e->getFile() . $e->getLine());
            return response()->json(['message' => 'Some error occured'], 400);
        }
    }

    public function pay(LoanPayRequest $request, $loanId){
        try{
            return [
                'message' => 'Success',
                'loan_details' => $this->loan->pay($loanId, $request->get('amount')),
            ];
        }
        catch(\Exception $e){
            logger()->error($e->getMessage(). $e->getFile() . $e->getLine());
            return response()->json(['message' => 'Some error occured'], 400);
        }
    }
}
