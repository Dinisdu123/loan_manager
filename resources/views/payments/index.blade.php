@extends('layout')

@section('content')
    

    <div class="container">
        <h1>Paid Payments</h1>

        @if ($payments->isEmpty())
            <p>No payments have been marked as paid yet.</p>
        @else
            <h2>Payment Details</h2>
            <table class="table table-bordered mb-4">
                <thead>
                    <tr>
                        <th>Lender</th>
                        <th>Payment Date</th>
                        <th>Paid Amount</th>
                        <th>Loan Amount</th>
                        <th>Interest Rate</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->loan->lender_name }}</td>
                            <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                            <td>{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ number_format($payment->loan->amount, 2) }}</td>
                            <td>{{ $payment->loan->interest_rate }}%</td>
                            <td>{{ $payment->loan->duration_months }} months</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <h2>Total Paid to Lender</h2>
        @if ($totals->isEmpty())
            <p>No payments recorded.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Lender</th>
                        <th>Total Paid</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($totals as $total)
                        <tr>
                            <td>{{ $total->lender_name }}</td>
                            <td>{{ number_format($total->total_paid, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
@endsection