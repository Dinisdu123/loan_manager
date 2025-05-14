@extends('layout')

@section('content')
    <div class="container mx-auto px-4 py-6 bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen animate-on-load">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6 animate__animated animate__fadeIn animate__fastest">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 drop-shadow-md">
                <i class="fas fa-history mr-2 text-indigo-600"></i>Loan History for {{ $user->name }}
            </h1>
            @if ($user->centers->isNotEmpty())
                <a href="{{ route('given_loans.center_members', $user->centers->first()->id) }}"
                   class="btn-custom bg-gradient-to-r from-gray-600 to-gray-800 text-white px-6 py-3 rounded-lg shadow-md hover:from-gray-700 hover:to-gray-900 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Members
                </a>
            @else
                <a href="{{ route('given_loans.index') }}"
                   class="btn-custom bg-gradient-to-r from-gray-600 to-gray-800 text-white px-6 py-3 rounded-lg shadow-md hover:from-gray-700 hover:to-gray-900 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Centers
                </a>
            @endif
        </div>

        <!-- Loan Summary -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 card-hover bg-gradient-to-br from-white to-gray-50 border border-indigo-200 animate__animated animate__fadeInUp animate__fastest">
            <h2 class="text-2xl font-semibold text-indigo-800 mb-4">Loan Summary</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Total Loan Amount:</strong> {{ number_format($totalLoansAmount, 2) }}</p>
                <p><strong>Total Duration:</strong> {{ $totalDurationMonths }} months</p>
                @if ($user->phone)
                    <p><strong>Phone:</strong> {{ $user->phone }}</p>
                @endif
                @if ($user->email)
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                @endif
            </div>
        </div>

        <!-- Loan List -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover bg-gradient-to-br from-white to-gray-50 border border-indigo-200 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeInUp animate__delay-200ms">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Center</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Amount</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Duration</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($loans as $loan)
                            <tr class="hover:bg-indigo-50 transition duration-200">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $loan->center->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ number_format($loan->amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $loan->duration_months }} months</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ ucfirst($loan->status) }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('given_loans.show', $loan->id) }}"
                                       class="btn-custom bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-blue-700 inline-flex items-center shadow-md">
                                        <i class="fas fa-eye mr-2"></i>View Loan
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-600">
                                    No loans found for this member.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection