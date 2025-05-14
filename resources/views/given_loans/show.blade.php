@extends('layout')

@section('content')
    <div class="container mx-auto px-4 py-6 bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen animate-on-load">
        <div class="flex justify-between items-center mb-6 animate__animated animate__fadeIn animate__fastest">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 drop-shadow-md">
                <i class="fas fa-money-check-alt mr-2 text-indigo-600"></i>Loan Details
            </h1>
            <div class="flex gap-4">
                @if ($loan && $loan->center)
                    <a href="{{ route('given_loans.center_members', $loan->center) }}"
                       class="btn-custom bg-gradient-to-r from-gray-600 to-gray-800 text-white px-6 py-3 rounded-lg shadow-md hover:from-gray-700 hover:to-gray-900 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Members
                    </a>
                @endif
                <a href="{{ route('given_loans.index') }}"
                   class="btn-custom bg-gradient-to-r from-gray-600 to-gray-800 text-white px-6 py-3 rounded-lg shadow-md hover:from-gray-700 hover:to-gray-900 flex items-center">
                    <i class="fas fa-home mr-2"></i>Back to Centers
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg shadow-md mb-6 animate__animated animate__bounceIn animate__fastest animate__delay-100ms">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded-lg shadow-md mb-6 animate__animated animate__bounceIn animate__fastest animate__delay-100ms">
                {{ session('error') }}
            </div>
        @endif

        @if ($loan)
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 card-hover border border-indigo-200 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeInUp animate__fastest animate__delay-200ms">
                <h2 class="text-2xl font-bold text-indigo-800 mb-4"><i class="fas fa-info-circle mr-2"></i>Loan Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
                    <div>
                        <p><strong>User:</strong> {{ $loan->user ? $loan->user->name : 'N/A' }}</p>
                        <p><strong>User Number:</strong> {{ $loan->user ? $loan->user->user_number : 'N/A' }}</p>
                        <p><strong>Center:</strong> {{ $loan->center ? $loan->center->name : 'N/A' }}</p>
                        <p><strong>Amount:</strong> {{ number_format($loan->amount, 2) }}</p>
                    </div>
                    <div>
                        <p><strong>Interest Rate:</strong> {{ $loan->interest_rate }}% per month</p>
                        <p><strong>Start Date:</strong> {{ $loan->start_date }}</p>
                        <p><strong>Status:</strong>
                            <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                                {{ $loan->status == 'active' ? 'bg-yellow-100 text-yellow-800' :
                                   ($loan->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </p>
                        <p><strong>Remaining Balance:</strong> {{ number_format($loan->remaining_balance, 2) }}</p>
                    </div>
                </div>
                @if ($loan->status != 'paid')
                    <form action="{{ route('given_loans.destroy', $loan->id) }}" method="POST" class="mt-4 inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this loan?')"
                                class="btn-custom bg-gradient-to-r from-red-600 to-pink-600 text-white px-4 py-2 rounded-lg hover:from-red-700 hover:to-pink-700 flex items-center">
                            <i class="fas fa-trash-alt mr-2"></i>Delete Loan
                        </button>
                    </form>
                @endif
            </div>

           
            <h2 class="text-2xl font-bold text-indigo-800 mb-4 animate__animated animate__fadeIn animate__fastest animate__delay-300ms">
                <i class="fas fa-list mr-2"></i>Payment Schedule
            </h2>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover bg-gradient-to-br from-white to-gray-50 border border-indigo-200 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeInUp animate__fastest animate__delay-400ms">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Payment Date</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Amount</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($payments as $payment)
                                @php
                                    $isOverdue = $payment->status == 'pending' && \Carbon\Carbon::parse($payment->payment_date)->isPast();
                                @endphp
                                <tr class="hover:bg-indigo-50 transition duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $payment->payment_date->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ number_format($payment->amount, 2) }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                                            {{ $isOverdue ? 'bg-red-100 text-red-800' :
                                               ($payment->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $isOverdue ? 'Overdue' : ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($payment->status == 'pending')
                                            <form action="{{ route('given_loans.mark_payment_paid', $payment) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                        class="btn-custom bg-gradient-to-r from-green-500 to-teal-500 text-white px-4 py-1 rounded-lg hover:from-green-600 hover:to-teal-600 flex items-center">
                                                    <i class="fas fa-check-circle mr-2"></i>Mark Paid
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-500">No Actions</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-600">
                                        No payments found for this loan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-red-100 text-red-800 p-4 rounded-lg shadow-md mb-6 animate__animated animate__bounceIn animate__fastest animate__delay-100ms">
                Loan not found.
            </div>
        @endif
    </div>
@endsection