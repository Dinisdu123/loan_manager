<?php

use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\GivenLoanController;
use App\Models\Payment;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

Route::get('/', function () {
    $nearestPayment = Payment::with('loan')
        ->where('status', 'pending')
        ->where('payment_date', '>=', Carbon::today()->subDays(30))
        ->orderBy('payment_date', 'asc')
        ->first();

    return view('dashboard', compact('nearestPayment'));
})->name('dashboard');

Route::resource('loans', LoanController::class);
Route::post('payments/{payment}/mark-paid', [LoanController::class, 'markPaymentPaid'])->name('payments.markPaid');
Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');








Route::get('/centers', [CenterController::class, 'index'])->name('centers.index');
Route::get('/centers/create', [CenterController::class, 'create'])->name('centers.create');
Route::post('/centers', [CenterController::class, 'store'])->name('centers.store');
Route::post('/centers/{center}/assign-leader', [CenterController::class, 'assignLeader'])->name('centers.assign-leader');
Route::post('/centers/{center}/add-member', [CenterController::class, 'addMember'])->name('centers.add-member');
Route::delete('/centers/{center}/remove-member', [CenterController::class, 'removeMember'])->name('centers.remove-member');

use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');



Route::get('/get-users/{centerId}', [GivenLoanController::class, 'getUsersByCenter']);


Route::get('/given-loans', [GivenLoanController::class, 'index'])->name('given_loans.index');
Route::get('/given-loans/create', [GivenLoanController::class, 'create'])->name('given_loans.create');
Route::post('/given-loans', [GivenLoanController::class, 'store'])->name('given_loans.store');
Route::get('/given-loans/{givenLoan}', [GivenLoanController::class, 'show'])->name('given_loans.show');

Route::delete('/given-loans/{givenLoan}', [GivenLoanController::class, 'destroy'])->name('given_loans.destroy');


// Route::get('/given-loans', [GivenLoanController::class, 'index'])->name('given_loans.index');
// Route::get('/given-loans/create', [GivenLoanController::class, 'create'])->name('given_loans.create');
// Route::post('/given-loans', [GivenLoanController::class, 'store'])->name('given_loans.store');
// Route::get('/given-loans/{loan}', [GivenLoanController::class, 'show'])->name('given_loans.show');
// Route::delete('/given-loans/{loan}', [GivenLoanController::class, 'destroy'])->name('given_loans.destroy');
// Route::post('/given-payments/{payment}/mark-paid', [GivenLoanController::class, 'markPaymentPaid'])->name('payments.markPaid');
// Route::get('/centers/{centerId}/users', [GivenLoanController::class, 'getUsersByCenter'])->name('centers.users');

// New routes
Route::get('/given-loans/center/{center}/members', [GivenLoanController::class, 'showCenterMembers'])->name('given_loans.center_members');
Route::get('/given-loans/member/{user}/loan', [GivenLoanController::class, 'showMemberLoan'])->name('given_loans.member_loan');
Route::get('/given-loans/history/{user}', [GivenLoanController::class, 'history'])->name('given_loans.history');


Route::get('/given-loans', [GivenLoanController::class, 'index'])->name('given_loans.index');
Route::get('/given-loans/create', [GivenLoanController::class, 'create'])->name('given_loans.create');
Route::post('/given-loans', [GivenLoanController::class, 'store'])->name('given_loans.store');
Route::get('/given-loans/{loan}', [GivenLoanController::class, 'show'])->name('given_loans.show');
Route::post('/given-loans/payments/{payment}/mark-paid', [GivenLoanController::class, 'markPaymentPaid'])->name('given_loans.mark_payment_paid'); // Add this
Route::delete('/given-loans/{loan}', [GivenLoanController::class, 'destroy'])->name('given_loans.destroy');
Route::get('/given-loans/center/{center}/members', [GivenLoanController::class, 'showCenterMembers'])->name('given_loans.center_members');
Route::get('/given-loans/member/{user}/loan', [GivenLoanController::class, 'showMemberLoan'])->name('given_loans.member_loan');
Route::get('/given-loans/report-search', [GivenLoanController::class, 'reportSearch'])->name('given_loans.report_search');
Route::get('/given-loans/report/{user_number}', [GivenLoanController::class, 'report'])->name('given_loans.report');
Route::get('/given-loans/center/{centerId}/users', [GivenLoanController::class, 'getUsersByCenter'])->name('given_loans.get_users_by_center');


// Route::get('/centers/{center}', [CenterController::class, 'show'])->name('centers.show');
Route::get('/given-loans/history/{user}', [GivenLoanController::class, 'history'])->name('given_loans.history');
Route::get('/centers/{center}/details', [CenterController::class, 'details'])->name('centers.details');

Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');