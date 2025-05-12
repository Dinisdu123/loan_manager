<?php

use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentController;
use App\Models\Payment;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

Route::get('/', function () {
    // Fetch the nearest pending payment (payment_date >= today or overdue)
    $nearestPayment = Payment::with('loan')
        ->where('status', 'pending')
        ->where('payment_date', '>=', Carbon::today()->subDays(30)) // Include recent overdue payments
        ->orderBy('payment_date', 'asc')
        ->first();

    return view('dashboard', compact('nearestPayment'));
})->name('dashboard');

Route::resource('loans', LoanController::class);
Route::post('payments/{payment}/mark-paid', [LoanController::class, 'markPaymentPaid'])->name('payments.markPaid');
Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');