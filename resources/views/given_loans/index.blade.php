@extends('layout')

@section('content')
    <div class="container mx-auto px-4 py-6 bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen animate-on-load">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6 animate__animated animate__fadeIn animate__fastest">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 drop-shadow-md">
                <i class="fas fa-clipboard-list mr-2 text-indigo-600"></i>Given Loans
            </h1>
            <a href="{{ route('given_loans.create') }}"
               class="btn-custom bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-700 flex items-center">
                <i class="fas fa-plus-circle mr-2"></i>Assign New Loan
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg shadow-md mb-6 animate__animated animate__bounceIn animate__fastest animate__delay-100ms">
                {{ session('success') }}
            </div>
        @endif

        <!-- Loans Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover bg-gradient-to-br from-white to-gray-50 border border-indigo-200 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeInUp animate__fastest animate__delay-200ms">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">User</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Center</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Amount</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($loans as $loan)
                            <tr class="hover:bg-indigo-50 transition duration-200">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $loan->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $loan->center->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ number_format($loan->amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                                        {{ $loan->status == 'active' ? 'bg-green-100 text-green-800' :
                                           ($loan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                           'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('given_loans.show', $loan->id) }}"
                                       class="btn-custom bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-blue-700 inline-flex items-center shadow-md">
                                        <i class="fas fa-eye mr-2"></i>View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-600">
                                    No loans found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($loans instanceof \Illuminate\Pagination\LengthAwarePaginator && $loans->hasPages())
            <div class="mt-6 flex justify-end animate__animated animate__fadeInUp animate__fastest animate__delay-300ms">
                {{ $loans->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection