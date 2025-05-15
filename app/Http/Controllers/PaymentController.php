<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('loan')
            ->where('status', 'paid')
            ->get();

        $totals = Payment::where('payments.status', 'paid')
            ->join('loans', 'payments.loan_id', '=', 'loans.id')
            ->groupBy('loans.lender_name')
            ->select('loans.lender_name', DB::raw('SUM(payments.amount) as total_paid'))
            ->get();

        return view('payments.index', compact('payments', 'totals'));
    }
}