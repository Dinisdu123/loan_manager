@extends('layout')

@section('content')
    <div class="container mx-auto px-4 py-6 bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen animate-on-load">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6 animate__animated animate__fadeIn animate__fastest">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 drop-shadow-md">
                <i class="fas fa-users mr-2 text-indigo-600"></i>User List
            </h1>
            <a href="{{ route('users.create') }}"
               class="btn-custom bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-700 flex items-center">
                <i class="fas fa-user-plus mr-2"></i>Add New User
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg shadow-md mb-6 animate__animated animate__bounceIn animate__fastest animate__delay-100ms">
                {{ session('success') }}
            </div>
        @endif

        <!-- Users Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover bg-gradient-to-br from-white to-gray-50 border border-indigo-200 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeInUp animate__fastest animate__delay-200ms">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">User Number</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">NIC</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Phone</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr class="hover:bg-indigo-50 transition duration-200">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $user->user_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $user->nic }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $user->phone }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $user->address ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-600">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->hasPages())
            <div class="mt-6 flex justify-end animate__animated animate__fadeInUp animate__fastest animate__delay-300ms">
                {{ $users->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection