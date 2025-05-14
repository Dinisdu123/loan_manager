@extends('layout')

@section('content')
    <div class="container mx-auto px-4 animate-on-load">
       
        <div class="flex justify-between items-center mb-8 animate__animated animate__fadeIn">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900">
                <i class="fas fa-list mr-2"></i>All Loans
            </h1>
            <a href="{{ route('loans.create') }}"
               class="btn-custom bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-green-600 flex items-center">
                <i class="fas fa-plus-circle mr-2"></i>Add New Loan
            </a>
        </div>

    
        <div class="bg-white rounded-xl shadow-xl overflow-hidden card-hover animate__animated animate__fadeInUp animate__delay-1s">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Lender</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Amount</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Interest Rate</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Duration</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Weekly Repayment</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Remaining Balance</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($loans as $loan)
                            <tr class="hover:bg-indigo-50 transition duration-200">
                                <td class="px-6 py-4 text-gray-800">{{ $loan->lender_name }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ number_format($loan->amount, 2) }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $loan->interest_rate }}%</td>
                                <td class="px-6 py-4 text-gray-800">{{ $loan->duration_months }} months</td>
                                <td class="px-6 py-4 text-gray-800">{{ number_format($loan->weekly_repayment, 2) }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ number_format($loan->remaining_balance, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                                        {{ $loan->status == 'active' ? 'bg-green-100 text-green-800' :
                                           ($loan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                           'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('loans.show', $loan) }}"
                                       class="btn-custom bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 inline-flex items-center">
                                        <i class="fas fa-eye mr-2"></i>View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-600">
                                    No loans found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination (if applicable) -->
        @if ($loans instanceof \Illuminate\Pagination\LengthAwarePaginator && $loans->hasPages())
            <div class="mt-6 flex justify-end">
                {{ $loans->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection