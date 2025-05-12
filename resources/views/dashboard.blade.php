@extends('layout')

@section('content')
    <div class="container text-center mt-5">
        <h1>Welcome to Loan Management System</h1>
     
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('loans.index') }}" class="btn btn-primary btn-lg">View All Loans</a>
            <a href="{{ route('loans.create') }}" class="btn btn-success btn-lg">Add New Loan</a>
            <a href="{{ route('payments.index') }}" class="btn btn-info btn-lg">View Payments</a>
        </div>

        <div class="mt-5">
            <h2>Nearest Upcoming Payment</h2>
            @if ($nearestPayment)
                @php
                    $isOverdue = \Carbon\Carbon::parse($nearestPayment->payment_date)->isBefore(now());
                @endphp
                <div class="card mx-auto" style="max-width: 500px;">
                    <div class="card-body">
                        <h5 class="card-title {{ $isOverdue ? 'text-danger' : '' }}">
                            Payment for {{ $nearestPayment->loan->lender_name }}
                        </h5>
                        <p class="card-text {{ $isOverdue ? 'text-danger' : '' }}">
                            <strong>Amount:</strong> {{ number_format($nearestPayment->amount, 2) }}<br>
                            <strong>Date:</strong> {{ $nearestPayment->payment_date->format('Y-m-d') }}<br>
                            <strong>Status:</strong> {{ $isOverdue ? 'Overdue' : 'Pending' }}
                        </p>
                        <form action="{{ route('payments.markPaid', $nearestPayment) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Mark as Paid</button>
                        </form>
                    </div>
                </div>
            @else
                <p>No upcoming or overdue payments found.</p>
            @endif
        </div>
    </div>
@endsection