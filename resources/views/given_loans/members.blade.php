@extends('layout')

@section('content')
    <div class="container mx-auto px-4 py-6 bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen animate-on-load">
        <div class="flex justify-between items-center mb-6 animate__animated animate__fadeIn animate__fastest">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 drop-shadow-md">
                <i class="fas fa-users mr-2 text-indigo-600"></i>Members of {{ $center->name }}
            </h1>
            <a href="{{ route('given_loans.index') }}"
               class="btn-custom bg-gradient-to-r from-gray-600 to-gray-800 text-white px-6 py-3 rounded-lg shadow-md hover:from-gray-700 hover:to-gray-900 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Back to Centers
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover bg-gradient-to-br from-white to-gray-50 border border-indigo-200 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeInUp animate__fastest animate__delay-200ms">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Member Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Has Active Loan</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($members as $member)
                            <tr class="hover:bg-indigo-50 transition duration-200">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $member->name }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                                        {{ $member->given_loans->isNotEmpty() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $member->given_loans->isNotEmpty() ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($member->given_loans->isNotEmpty())
                                        <a href="{{ route('given_loans.member_loan', $member->id) }}"
                                           class="btn-custom bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-blue-700 inline-flex items-center shadow-md">
                                            <i class="fas fa-eye mr-2"></i>View More
                                        </a>
                                    @else
                                        <span class="text-gray-500">No Loan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-600">
                                    No members found for this center.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection