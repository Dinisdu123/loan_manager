<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\User;
use App\Models\GivenLoan;
use App\Models\GivenPayment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GivenLoanController extends Controller
{
    public function create()
    {
        $centers = Center::with('members')->get();
        return view('given_loans.create', compact('centers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'center_id' => 'required|exists:centers,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'start_date' => 'required|date',
        ]);

        $amount = $request->amount;
        $interest_rate = $request->interest_rate / 100; // Convert to decimal
        $duration_months = $request->duration_months;

        // Calculate total repayment (simple interest)
        $interest = $amount * $interest_rate * $duration_months;
        $total_repayment = $amount + $interest;

        // Calculate weekly repayment
        $weeks = $duration_months * 4; // Approximate 4 weeks per month
        $weekly_repayment = $total_repayment / $weeks;

        $loan = GivenLoan::create([
            'user_id' => $request->user_id,
            'center_id' => $request->center_id,
            'amount' => $amount,
            'interest_rate' => $request->interest_rate,
            'duration_months' => $duration_months,
            'start_date' => $request->start_date,
            'total_repayment' => $total_repayment,
            'weekly_repayment' => $weekly_repayment,
            'remaining_balance' => $total_repayment,
            'status' => 'active',
        ]);

        // Generate payment schedule
        $current_date = Carbon::parse($request->start_date)->addWeek();
        for ($i = 0; $i < $weeks; $i++) {
            GivenPayment::create([
                'given_loan_id' => $loan->id,
                'amount' => $weekly_repayment,
                'payment_date' => $current_date->copy()->addWeeks($i),
                'status' => 'pending',
            ]);
        }

        return redirect()->route('given_loans.index')->with('success', 'Loan assigned successfully.');
    }

    public function index()
    {
        $loans = GivenLoan::with('user', 'center')->get();
        return view('given_loans.index', compact('loans'));
    }

    public function show(GivenLoan $loan)
    {
        $payments = $loan->payments;
        return view('given_loans.show', compact('loan', 'payments'));
    }

    public function markPaymentPaid(Request $request, GivenPayment $payment)
    {
        $payment->update(['status' => 'paid']);

        $loan = $payment->loan;
        $loan->remaining_balance -= $payment->amount;
        if ($loan->remaining_balance <= 0) {
            $loan->status = 'paid';
        }
        $loan->save();

        return redirect()->back()->with('success', 'Payment marked as paid.');
    }

    public function destroy(GivenLoan $loan)
    {
        $loan->delete();
        return redirect()->route('given_loans.index')->with('success', 'Loan deleted successfully.');
    }
    public function getUsersByCenter($centerId)
{
    $center = Center::with('members')->findOrFail($centerId);
    return response()->json($center->members);
}
}