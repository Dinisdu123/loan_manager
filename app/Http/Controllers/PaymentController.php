<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        // Fetch only paid payments with related loan details
        $payments = Payment::with('loan')
            ->where('status', 'paid')
            ->get();

        // Calculate total paid amount per lender
        $totals = Payment::where('payments.status', 'paid')
            ->join('loans', 'payments.loan_id', '=', 'loans.id')
            ->groupBy('loans.lender_name')
            ->select('loans.lender_name', DB::raw('SUM(payments.amount) as total_paid'))
            ->get();

        return view('payments.index', compact('payments', 'totals'));
    }
}