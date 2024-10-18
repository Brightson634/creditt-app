<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Member\AuthController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\SavingController;
use App\Http\Controllers\Member\LoanController;
use App\Http\Controllers\Member\TransactionController;


Route::prefix('member')->name('member.')->group(function () 
{

   Route::get('/', [AuthController::class, 'loginForm'])->name('login');
   Route::post('/login/member',           [AuthController::class,'login'])->name('login.member');


    Route::middleware('auth:member')->group(function()
   {
      Route::get('/dashboard/{id}',  [DashboardController::class,'index'])->name('dashboard');
      Route::get('/account',   [ProfileController::class,'account'])->name('account');

      Route::get('/password',   [ProfileController::class,'password'])->name('password');
      Route::post('/password/update', [ProfileController::class,'updatePassword'])->name('password.update');

      Route::get('/profile',   [ProfileController::class,'profile'])->name('profile');
      Route::post('profile/update',  [ProfileController::class,'profileUpdate'])->name('profile.update');
      Route::post('/profilephoto',  [ProfileController::class,'profilePhoto'])->name('profile.photo');

      Route::get('/notifications',    [DashboardController::class,'notifications'])->name('notifications');
      Route::get('/logout',[ProfileController::class,'logout'])->name('logout');


      Route::get('savings',         [SavingController::class,'index'])->name('savings');
      Route::get('saving/save',     [SavingController::class,'savingCreate'])->name('saving.create');
      Route::post('saving/store',   [SavingController::class,'savingStore'])->name('saving.store');

      Route::get('mysavings',         [SavingController::class,'mySavings'])->name('mysavings');

      Route::get('loans',          [LoanController::class,'index'])->name('loans');
      Route::get('myloans',          [LoanController::class,'myLoans'])->name('myloans');
      Route::get('loan/apply',     [LoanController::class,'loanCreate'])->name('loan.create');
      Route::post('loan/store',    [LoanController::class,'loanStore'])->name('loan.store');

      Route::get('/transactions',   [TransactionController::class,'transactions'])->name('transactions');
 });

});