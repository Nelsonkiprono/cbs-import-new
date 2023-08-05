<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dummy', [App\Http\Controllers\HomeController::class, 'dummy'])->name('dummy');
Route::get('/joined', [App\Http\Controllers\HomeController::class, 'joined'])->name('joined');
Route::get('/getusers', [App\Http\Controllers\HomeController::class, 'getusers'])->name('getusers');
Route::get('/initializeperloan', [App\Http\Controllers\LoanController::class, 'initializeperloan'])->name('initializeperloan');

Route::get('/initloanpayment', [App\Http\Controllers\LoanController::class, 'initloanpayment'])->name('initloanpayment');

Route::get('/date', [App\Http\Controllers\HomeController::class, 'formatedate'])->name('formatedate');
Route::get('/repayments', [App\Http\Controllers\HomeController::class, 'getRepayments'])->name('getRepayments');
Route::get('/testadd', [App\Http\Controllers\HomeController::class, 'startofpaymentdate'])->name('startofpaymentdate');
Route::get('/comparedate', [App\Http\Controllers\HomeController::class, 'compareDates'])->name('compareDates');

Route::get('/transactions', [App\Http\Controllers\LoanController::class, 'getTransactions'])->name('getTransactions');
