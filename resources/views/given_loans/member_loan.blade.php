@extends('layout')

@section('content')
    <div class="container mx-auto px-4 py-6 bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen animate-on-load">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6 animate__animated animate__fadeIn animate__fastest">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 drop-shadow-md">
                <i class="fas fa-landmark mr-2 text-indigo-600"></i>Loan Details for {{ $user->name }}
            </h1>
            <a href="{{ route('given_loans.center_members', $loan->center_id) }}"
               class="btn-custom bg-gradient-to-r from-gray-600 to-gray-800 text-white px-6 py-3 rounded-lg shadow-md hover:from-gray-700 hover:to-gray-900 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Back to Members
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg shadow-md mb-6 animate__animated animate__bounceIn animate__fastest animate__delay-100ms">
                {{ session('success') }}
            </div>
        @endif

        <!-- Loan Details Card -->
        <div class="card-hover bg-white p-6 rounded-xl shadow-xl mt-6 max-w-2xl mx-auto animate__animated animate__fadeInUp animate__delay-1s">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <p class="text-gray-700">
                    <strong class="text-indigo-600"><i class="fas fa-money-bill mr-1"></i>Amount:</strong> {{ number_format($loan->amount, 2) }}
                </p>
                <p class="text-gray-700">
                    <strong class="text-indigo-600"><i class="fas fa-percentage mr-1"></i>Interest Rate:</strong> {{ $loan->interest_rate }}% per month
                </p>
                <p class="text-gray-700">
                    <strong class="text-indigo-600"><i class="fas fa-clock mr-1"></i>Duration:</strong> {{ $loan->duration_months }} months
                </p>
                <p class="text-gray-700">
                    <strong class="text-indigo-600"><i class="fas fa-calendar-alt mr-1"></i>Start Date:</strong> {{ $loan->start_date }}
                </p>
                <p class="text-gray-700">
                    <strong class="text-indigo-600"><i class="fas fa-wallet mr-1"></i>Total Repayment:</strong> {{ number_format($loan->total_repayment, 2) }}
                </p>
                <p class="text-gray-700">
                    <strong class="text-indigo-600"><i class="fas fa-receipt mr-1"></i>Weekly Repayment:</strong> {{ number_format($loan->weekly_repayment, 2) }}
                </p>
                <p class="text-gray-700">
                    <strong class="text-indigo-600"><i class="fas fa-balance-scale mr-1"></i>Remaining Balance:</strong> {{ number_format($loan->remaining_balance, 2) }}
                </p>
                <p class="text-gray-700">
                    <strong class="text-indigo-600"><i class="fas fa-info-circle mr-1"></i>Status:</strong>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $loan->status == 'active' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        {{ ucfirst($loan->status) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Payment Schedule -->
        <h2 class="text-2xl font-bold text-indigo-800 mt-12 mb-6 animate__animated animate__fadeIn animate__delay-3s">
            <i class="fas fa-calendar-check mr-2"></i>Payment Schedule
        </h2>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover bg-gradient-to-br from-white to-gray-50 border border-indigo-200 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeInUp animate__delay-4s">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Payment Date</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Amount</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($payments as $payment)
                            @php
                                $isOverdue = $payment->status == 'pending' && \Carbon\Carbon::parse($payment->payment_date)->isPast();
                            @endphp
                            <tr class="hover:bg-indigo-50 transition duration-200">
                                <td class="px-6 py-4 {{ $isOverdue ? 'text-red-600 font-semibold' : 'text-gray-700' }}">
                                    {{ $payment->payment_date->format('Y-m-d') }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $isOverdue ? 'bg-red-100 text-red-600' : ($payment->status == 'paid' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600') }}">
                                        {{ $isOverdue ? 'Overdue' : ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($payment->status == 'pending')
                                        <form action="{{ route('payments.markPaid', $payment->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-custom bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 inline-flex items-center shadow-md">
                                                <i class="fas fa-check-circle mr-2"></i>Mark Paid
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">Paid</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Delete Loan Button -->
        <div class="mt-6 text-center animate__animated animate__fadeInUp animate__delay-2s">
            <form action="{{ route('given_loans.destroy', $loan->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this loan? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-custom bg-red-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-red-600">
                    <i class="fas fa-trash-alt mr-2"></i>Delete Loan
                </button>
            </form>
        </div>
    </div>
@endsection