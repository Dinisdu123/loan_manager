@extends('layout')

@section('content')
    <div class="container mx-auto mt-10 px-4 animate-on-load">
        <!-- Form Header -->
        <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 animate__animated animate__fadeIn">
            <i class="fas fa-plus-circle mr-2"></i>Add New Loan
        </h1>
        <p class="mt-2 text-lg text-gray-600 animate__animated animate__fadeIn animate__delay-1s">
            Fill in the details below to create a new loan.
        </p>

        <!-- Form Card -->
        <div class="card-hover bg-white p-6 rounded-xl shadow-xl mt-6 max-w-lg mx-auto animate__animated animate__fadeInUp animate__delay-2s">
            <form action="{{ route('loans.store') }}" method="POST">
                @csrf
                <!-- Lender Name -->
                <div class="mb-4">
                    <label for="lender_name" class="block text-indigo-600 font-semibold mb-2">
                        <i class="fas fa-user mr-1"></i>Lender Name
                    </label>
                    <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 {{ $errors->has('lender_name') ? 'border-red-500' : 'border-gray-300' }}" id="lender_name" name="lender_name" required value="{{ old('lender_name') }}">
                    @error('lender_name')
                        <p class="text-red-500 text-sm mt-1 animate__animated animate__shakeX">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Loan Amount -->
                <div class="mb-4">
                    <label for="amount" class="block text-indigo-600 font-semibold mb-2">
                        <i class="fas fa-money-bill mr-1"></i>Loan Amount
                    </label>
                    <input type="number" step="0.01" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 {{ $errors->has('amount') ? 'border-red-500' : 'border-gray-300' }}" id="amount" name="amount" required value="{{ old('amount') }}">
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1 animate__animated animate__shakeX">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Interest Rate -->
                <div class="mb-4">
                    <label for="interest_rate" class="block text-indigo-600 font-semibold mb-2">
                        <i class="fas fa-percentage mr-1"></i>Interest Rate (% per month)
                    </label>
                    <input type="number" step="0.01" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 {{ $errors->has('interest_rate') ? 'border-red-500' : 'border-gray-300' }}" id="interest_rate" name="interest_rate" required value="{{ old('interest_rate') }}">
                    @error('interest_rate')
                        <p class="text-red-500 text-sm mt-1 animate__animated animate__shakeX">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duration -->
                <div class="mb-4">
                    <label for="duration_months" class="block text-indigo-600 font-semibold mb-2">
                        <i class="fas fa-clock mr-1"></i>Duration (Months)
                    </label>
                    <input type="number" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 {{ $errors->has('duration_months') ? 'border-red-500' : 'border-gray-300' }}" id="duration_months" name="duration_months" required value="{{ old('duration_months') }}">
                    @error('duration_months')
                        <p class="text-red-500 text-sm mt-1 animate__animated animate__shakeX">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Start Date -->
                <div class="mb-4">
                    <label for="start_date" class="block text-indigo-600 font-semibold mb-2">
                        <i class="fas fa-calendar-alt mr-1"></i>Start Date
                    </label>
                    <input type="date" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 {{ $errors->has('start_date') ? 'border-red-500' : 'border-gray-300' }}" id="start_date" name="start_date" required value="{{ old('start_date') }}">
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1 animate__animated animate__shakeX">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn-custom bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition duration-300">
                        <i class="fas fa-save mr-2"></i>Save Loan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection