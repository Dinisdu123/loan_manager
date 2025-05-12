@extends('layout')

@section('content')
    <div class="container mx-auto px-4 animate-on-load">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8 animate__animated animate__fadeIn animate__faster">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900">
                <i class="fas fa-money-bill mr-2"></i>Paid Payments
            </h1>
        </div>

        <!-- Payment Details Section -->
        <div class="mb-12 animate__animated animate__fadeInUp animate__faster animate__delay-200ms">
            <h2 class="text-2xl font-bold text-indigo-800 mb-6">
                Payment Details
            </h2>
            @if ($payments->isEmpty())
                <div class="bg-white p-6 rounded-xl shadow-xl card-hover text-center text-gray-600">
                    No payments have been marked as paid yet.
                </div>
            @else
                <div class="bg-white rounded-xl shadow-xl overflow-hidden card-hover">
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Lender</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Payment Date</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Paid Amount</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Loan Amount</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Interest Rate</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Duration</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($payments as $payment)
                                    <tr class="hover:bg-indigo-50 transition duration-200">
                                        <td class="px-6 py-4 text-gray-800">{{ $payment->loan->lender_name }}</td>
                                        <td class="px-6 py-4 text-gray-800">{{ $payment->payment_date->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 text-gray-800">{{ number_format($payment->amount, 2) }}</td>
                                        <td class="px-6 py-4 text-gray-800">{{ number_format($payment->loan->amount, 2) }}</td>
                                        <td class="px-6 py-4 text-gray-800">{{ $payment->loan->interest_rate }}%</td>
                                        <td class="px-6 py-4 text-gray-800">{{ $payment->loan->duration_months }} months</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pagination (if applicable) -->
                @if ($payments instanceof \Illuminate\Pagination\LengthAwarePaginator && $payments->hasPages())
                    <div class="mt-6 flex justify-end">
                        {{ $payments->links('pagination::tailwind') }}
                    </div>
                @endif
            @endif
        </div>

        <!-- Total Paid to Lender Section -->
        <div class="animate__animated animate__fadeInUp animate__faster animate__delay-400ms">
            <h2 class="text-2xl font-bold text-indigo-800 mb-6">
                Total Paid to Lender
            </h2>
            @if ($totals->isEmpty())
                <div class="bg-white p-6 rounded-xl shadow-xl card-hover text-center text-gray-600">
                    No payments recorded.
                </div>
            @else
                <div class="bg-white rounded-xl shadow-xl overflow-hidden card-hover">
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Lender</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Total Paid</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($totals as $total)
                                    <tr class="hover:bg-indigo-50 transition duration-200">
                                        <td class="px-6 py-4 text-gray-800">{{ $total->lender_name }}</td>
                                        <td class="px-6 py-4 text-gray-800">{{ number_format($total->total_paid, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pagination for totals (if applicable) -->
                @if ($totals instanceof \Illuminate\Pagination\LengthAwarePaginator && $totals->hasPages())
                    <div class="mt-6 flex justify-end">
                        {{ $totals->links('pagination::tailwind') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection