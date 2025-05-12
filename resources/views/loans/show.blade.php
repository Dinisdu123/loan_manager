@extends('layout')

@section('content')
    <h1>Loan Details: {{ $loan->lender_name }}</h1>
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Amount:</strong> {{ number_format($loan->amount, 2) }}</p>
            <p><strong>Interest Rate:</strong> {{ $loan->interest_rate }}% per month</p>
            <p><strong>Duration:</strong> {{ $loan->duration_months }} months</p>
            <p><strong>Start Date:</strong> {{ $loan->start_date }}</p>
            <p><strong>Total Repayment:</strong> {{ number_format($loan->total_repayment, 2) }}</p>
            <p><strong>Weekly Repayment:</strong> {{ number_format($loan->weekly_repayment, 2) }}</p>
            <p><strong>Remaining Balance:</strong> {{ number_format($loan->remaining_balance, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($loan->status) }}</p>
        </div>
    </div>

    <div class="mb-4">
        <form action="{{ route('loans.destroy', $loan) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this loan? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Loan</button>
        </form>
    </div>

    <h2>Payment Schedule</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Payment Date</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                @php
                    $isOverdue = $payment->status == 'pending' && \Carbon\Carbon::parse($payment->payment_date)->isBefore(now());
                @endphp
                <tr>
                    <td class="{{ $isOverdue ? 'text-danger' : '' }}">{{ $payment->payment_date->format('Y-m-d') }}</td>
                    <td>{{ number_format($payment->amount, 2) }}</td>
                    <td class="{{ $isOverdue ? 'text-danger' : '' }}">{{ $isOverdue ? 'Overdue' : ucfirst($payment->status) }}</td>
                    <td>
                        @if ($payment->status == 'pending')
                            <form action="{{ route('payments.markPaid', $payment) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Mark Paid</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection