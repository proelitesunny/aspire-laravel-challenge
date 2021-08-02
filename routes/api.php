<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('loans/enquiry', [LoanController::class, 'enquiry'])->name('loans.enquiry');
    Route::post('loans', [LoanController::class, 'store'])->name('loans.store');
    Route::get('loans/{loan_id}', [LoanController::class, 'show'])->name('loans.show');

    Route::post('loans/{loan_id}/pay', [LoanController::class, 'pay'])->name('loans.pay');
});
