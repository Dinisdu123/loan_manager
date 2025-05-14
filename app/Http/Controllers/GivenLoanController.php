<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\User;
use App\Models\GivenLoan;
use App\Models\GivenPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Twilio\Rest\Client;

class GivenLoanController extends Controller
{
    public function create()
    {
        $centers = Center::with(['members' => function ($query) {
            $query->whereDoesntHave('given_loans', function ($loanQuery) {
                $loanQuery->where('status', 'active')
                          ->whereHas('payments', function ($paymentQuery) {
                              $paymentQuery->where('status', 'pending');
                          });
            });
        }])->get();
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

        $existingLoan = GivenLoan::where('user_id', $request->user_id)
            ->where('status', 'active')
            ->whereHas('payments', function ($query) {
                $query->where('status', 'pending');
            })->first();

        if ($existingLoan) {
            return redirect()->back()->withInput()->with('error', 'This user already has an active loan with pending installments.');
        }

        $amount = $request->amount;
        $interest_rate = $request->interest_rate / 100;
        $duration_months = $request->duration_months;

        $interest = $amount * $interest_rate * $duration_months;
        $total_repayment = $amount + $interest;

        $weeks = $duration_months * 4;
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

        $current_date = Carbon::parse($request->start_date)->addDays(7);
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
        $centers = Center::all();
        return view('given_loans.index', compact('centers'));
    }

    public function show($id)
    {
        $loan = GivenLoan::with('center', 'user', 'payments')->find($id);
        if (!$loan) {
            return redirect()->route('given_loans.report_search')->with('error', 'Loan not found.');
        }
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

        // Send SMS to user
        $user = $loan->user;
        if ($user && $user->phone) {
            try {
                
                $formattedPhoneNumber = preg_replace('/^0/', '+94', $user->phone);
                Log::debug('Attempting to send SMS to: ' . $formattedPhoneNumber . ' for user ID: ' . $user->id);
                
                $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
                $message = "Dear {$user->name}, your installment of LKR {$payment->amount}  has been Recieved " . now()->format('Y-m-d') . ". You have LKR " . number_format($loan->remaining_balance, 2) . " left to pay. Thank you! Reply STOP to unsubscribe.";
                $twilio->messages->create(
                    $formattedPhoneNumber,
                    [
                        'from' => config('services.twilio.from'),
                        'body' => $message,
                    ]
                );
                Log::info('SMS sent successfully to: ' . $formattedPhoneNumber);
            } catch (\Exception $e) {
                Log::error('Failed to send SMS to ' . $formattedPhoneNumber . ' for user ID ' . $user->id . ': ' . $e->getMessage());
            }
        } else {
            Log::warning('SMS not sent for user ID ' . ($user ? $user->id : 'unknown') . ': Missing phone');
        }

        return redirect()->back()->with('success', 'Payment marked as paid.');
    }

    public function destroy(GivenLoan $loan)
    {
        if (!$loan->exists) {
            return redirect()->route('given_loans.report_search')->with('error', 'Loan not found.');
        }
        $loan->delete();
        return redirect()->route('given_loans.index')->with('success', 'Loan deleted successfully.');
    }

    public function getUsersByCenter($centerId)
    {
        $center = Center::with(['members' => function ($query) {
            $query->whereDoesntHave('given_loans', function ($loanQuery) {
                $loanQuery->where('status', 'active')
                          ->whereHas('payments', function ($paymentQuery) {
                              $paymentQuery->where('status', 'pending');
                          });
            });
        }])->findOrFail($centerId);
        return response()->json($center->members);
    }

    public function showCenterMembers(Center $center)
    {
        $members = $center->members()->with(['given_loans' => function ($query) {
            $query->where('status', 'active');
        }])->get();
        return view('given_loans.members', compact('center', 'members'));
    }

    public function showMemberLoan(User $user)
    {
        $loan = GivenLoan::where('user_id', $user->id)
            ->where('status', 'active')
            ->with('payments', 'center', 'user')
            ->first();
        if (!$loan) {
            $center = $user->centers->first();
            if ($center) {
                return redirect()->route('given_loans.center_members', $center->id)
                    ->with('error', 'No active loan found for this member.');
            }
            return redirect()->route('given_loans.report_search')
                ->with('error', 'No active loan found and user is not associated with any center.');
        }
        $payments = $loan->payments;
        return view('given_loans.show', compact('loan', 'payments'));
    }

    public function reportSearch()
    {
        return view('given_loans.report_search');
    }

    public function report($user_number)
    {
        $user = User::where('user_number', $user_number)->with('given_loans.payments')->firstOrFail();
        $loans = $user->given_loans;
        $total_loans = $loans->count();
        $completed_loans = $loans->where('status', 'paid')->count();
        $active_loans = $loans->where('status', 'active')->count();
        $unpaid_loans = $loans->where('status', 'active')->where('remaining_balance', '>', 0)->count();
        $overdue_payments = 0;
        foreach ($loans as $loan) {
            $overdue_payments += $loan->payments->where('status', 'pending')
                ->where('payment_date', '<', Carbon::today())
                ->count();
        }
        return view('given_loans.report', compact('user', 'loans', 'total_loans', 'completed_loans', 'active_loans', 'unpaid_loans', 'overdue_payments'));
    }
    public function history(User $user)
{
    $loans = GivenLoan::with('center')
        ->where('user_id', $user->id)
        ->get();

    $totalLoansAmount = $loans->sum('amount');
    $totalDurationMonths = $loans->sum('duration_months');

    return view('given_loans.history', compact('user', 'loans', 'totalLoansAmount', 'totalDurationMonths'));
}
}
?>