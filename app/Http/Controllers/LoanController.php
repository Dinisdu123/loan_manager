<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::all();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        return view('loans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lender_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'start_date' => 'required|date',
        ]);

        $amount = $request->amount;
        $interest_rate = $request->interest_rate / 100; 
        $duration_months = $request->duration_months;

        $interest = $amount * $interest_rate * $duration_months;
        $total_repayment = $amount + $interest;

        // Calculate weekly repayment
        $weeks = $duration_months * 4; 
        $weekly_repayment = $total_repayment / $weeks;

        $loan = Loan::create([
            'lender_name' => $request->lender_name,
            'amount' => $amount,
            'interest_rate' => $request->interest_rate,
            'duration_months' => $duration_months,
            'start_date' => $request->start_date,
            'total_repayment' => $total_repayment,
            'weekly_repayment' => $weekly_repayment,
            'remaining_balance' => $total_repayment,
            'status' => 'active',
        ]);

      
        $current_date = Carbon::parse($request->start_date)->addWeek(); 
        for ($i = 0; $i < $weeks; $i++) {
            Payment::create([
                'loan_id' => $loan->id,
                'amount' => $weekly_repayment,
                'payment_date' => $current_date->copy()->addWeeks($i),
                'status' => 'pending',
            ]);
        }

        return redirect()->route('loans.index')->with('success', 'Loan created successfully.');
    }

    public function show(Loan $loan)
    {
        $payments = $loan->payments;
        return view('loans.show', compact('loan', 'payments'));
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully.');
    }

    public function markPaymentPaid(Request $request, Payment $payment)
    {
        $payment->update(['status' => 'paid']);

        // Update loan's remaining balance
        $loan = $payment->loan;
        $loan->remaining_balance -= $payment->amount;
        if ($loan->remaining_balance <= 0) {
            $loan->status = 'paid';
        }
        $loan->save();

        return redirect()->back()->with('success', 'Payment marked as paid.');
    }
}