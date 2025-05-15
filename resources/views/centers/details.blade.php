@extends('layout')

@section('content')
    <div class="container mx-auto px-4 py-6 bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen animate-on-load">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6 animate__animated animate__fadeIn animate__fastest">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 drop-shadow-md">
                <i class="fas fa-building mr-2 text-indigo-600"></i>Center Details: {{ $center->name }}
            </h1>
            <a href="{{ route('centers.index') }}"
               class="btn-custom bg-gradient-to-r from-gray-600 to-gray-800 text-white px-6 py-3 rounded-lg shadow-md hover:from-gray-700 hover:to-gray-900 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Back to Centers
            </a>
        </div>

        <!-- Center Overview -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 card-hover bg-gradient-to-br from-white to-gray-50 border border-indigo-200 animate__animated animate__fadeInUp animate__fastest">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-indigo-800">Overview</h2>
                <div class="flex gap-2">
                    <a href="{{ route('centers.edit', $center->id) }}"
                       class="btn-custom bg-gradient-to-r from-yellow-600 to-orange-600 text-white px-4 py-2 rounded-lg hover:from-yellow-700 hover:to-orange-700 flex items-center shadow-md">
                        <i class="fas fa-edit mr-2"></i>Edit Center
                    </a>
                    <form action="{{ route('centers.destroy', $center->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this center?')"
                                class="btn-custom bg-gradient-to-r from-red-600 to-pink-600 text-white px-4 py-2 rounded-lg hover:from-red-700 hover:to-pink-700 flex items-center shadow-md">
                            <i class="fas fa-trash-alt mr-2"></i>Delete Center
                        </button>
                    </form>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
                <p><strong>Name:</strong> {{ $center->name }}</p>
                <p><strong>Nickname:</strong> {{ $center->nickname }}</p>
                <p><strong>Leader:</strong> {{ $center->leader ? $center->leader->name : 'None' }}</p>
                <p><strong>Total Members:</strong> {{ $center->members->count() }}</p>
            </div>
        </div>

        <!-- Members List -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover bg-gradient-to-br from-white to-gray-50 border border-indigo-200 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeInUp animate__delay-200ms">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Member Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">User Number</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Address</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Phone</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($center->members as $member)
                            <tr class="hover:bg-indigo-50 transition duration-200">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $member->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $member->user_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $member->address ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $member->phone ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm flex gap-2">
                                    <a href="{{ route('given_loans.history', $member->id) }}"
                                       class="btn-custom bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-blue-700 inline-flex items-center shadow-md">
                                        <i class="fas fa-history mr-2"></i>View Loan History
                                    </a>
                                    <a href="{{ route('users.edit', $member->id) }}"
                                       class="btn-custom bg-gradient-to-r from-yellow-600 to-orange-600 text-white px-4 py-2 rounded-lg hover:from-yellow-700 hover:to-orange-700 inline-flex items-center shadow-md">
                                        <i class="fas fa-edit mr-2"></i>Edit User
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-600">
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