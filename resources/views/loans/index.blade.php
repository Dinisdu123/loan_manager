@extends('layout')

@section('content')
    <h1>All Loans</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Lender</th>
                <th>Amount</th>
                <th>Interest Rate</th>
                <th>Duration</th>
                <th>Weekly Repayment</th>
                <th>Remaining Balance</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $loan)
                <tr>
                    <td>{{ $loan->lender_name }}</td>
                    <td>{{ number_format($loan->amount, 2) }}</td>
                    <td>{{ $loan->interest_rate }}%</td>
                    <td>{{ $loan->duration_months }} months</td>
                    <td>{{ number_format($loan->weekly_repayment, 2) }}</td>
                    <td>{{ number_format($loan->remaining_balance, 2) }}</td>
                    <td>{{ ucfirst($loan->status) }}</td>
                    <td>
                        <a href="{{ route('loans.show', $loan) }}" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection