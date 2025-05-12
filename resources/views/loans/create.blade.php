@extends('layout')

@section('content')
    <h1>Add New Loan</h1>
    <form action="{{ route('loans.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="lender_name" class="form-label">Lender Name</label>
            <input type="text" class="form-control" id="lender_name" name="lender_name" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Loan Amount</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="mb-3">
            <label for="interest_rate" class="form-label">Interest Rate (% per month)</label>
            <input type="number" step="0.01" class="form-control" id="interest_rate" name="interest_rate" required>
        </div>
        <div class="mb-3">
            <label for="duration_months" class="form-label">Duration (Months)</label>
            <input type="number" class="form-control" id="duration_months" name="duration_months" required>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Loan</button>
    </form>
@endsection