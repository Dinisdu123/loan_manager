@extends('layout')

@section('content')
    <div class="container mx-auto px-4 py-6 bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen animate-on-load">
        <div class="flex justify-between items-center mb-6 animate__animated animate__fadeIn animate__fastest">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 drop-shadow-md">
                <i class="fas fa-building mr-2 text-indigo-600"></i>Centers Overview
            </h1>
            <a href="{{ route('centers.create') }}"
               class="btn-custom bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-700 flex items-center">
                <i class="fas fa-plus-circle mr-2"></i>Create New Center
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg shadow-md mb-6 animate__animated animate__bounceIn animate__fastest animate__delay-100ms">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover bg-gradient-to-br from-white to-gray-50 border border-indigo-200 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeInUp animate__fastest animate__delay-200ms">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Nickname</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Leader</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Members</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($centers as $center)
                            <tr class="hover:bg-indigo-50 transition duration-200">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $center->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $center->nickname }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $center->leader ? $center->leader->name : 'None' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $center->members->count() }}</td>
                                <td class="px-6 py-4 text-sm space-x-2">
                                    <button onclick="document.getElementById('assign-leader-{{ $center->id }}').showModal()"
                                            class="btn-custom bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-indigo-700 inline-flex items-center shadow-md">
                                        <i class="fas fa-user-tie mr-2"></i>Assign Leader
                                    </button>
                                    <button onclick="document.getElementById('add-member-{{ $center->id }}').showModal()"
                                            class="btn-custom bg-gradient-to-r from-green-600 to-teal-600 text-white px-4 py-2 rounded-lg hover:from-green-700 hover:to-teal-700 inline-flex items-center shadow-md">
                                        <i class="fas fa-user-plus mr-2"></i>Add Member
                                    </button>
                                    <button onclick="document.getElementById('remove-member-{{ $center->id }}').showModal()"
                                            class="btn-custom bg-gradient-to-r from-red-600 to-pink-600 text-white px-4 py-2 rounded-lg hover:from-red-700 hover:to-pink-700 inline-flex items-center shadow-md">
                                        <i class="fas fa-user-minus mr-2"></i>Remove Member
                                    </button>
                                    <a href="{{ route('centers.details', $center->id) }}"
                                       class="btn-custom bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-lg hover:from-purple-700 hover:to-pink-700 inline-flex items-center shadow-md">
                                        <i class="fas fa-eye mr-2"></i>View Center
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-600">
                                    No centers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($centers instanceof \Illuminate\Pagination\LengthAwarePaginator && $centers->hasPages())
            <div class="mt-6 flex justify-end animate__animated animate__fadeInUp animate__fastest animate__delay-300ms">
                {{ $centers->links('pagination::tailwind') }}
            </div>
        @endif

        @foreach ($centers as $center)
            <dialog id="assign-leader-{{ $center->id }}"
                    class="p-6 bg-white rounded-xl shadow-lg max-w-md w-full bg-gradient-to-br from-white to-gray-50 border border-indigo-200 animate__animated animate__zoomIn animate__fastest">
                <h2 class="text-xl font-bold text-indigo-900 mb-4">
                    <i class="fas fa-user-tie mr-2 text-indigo-600"></i>Assign Leader to {{ $center->name }}
                </h2>
                <form method="POST" action="{{ route('centers.assign-leader', $center->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="leader_id-{{ $center->id }}" class="block text-sm font-medium text-indigo-800">Select Leader</label>
                        <select name="leader_id" id="leader_id-{{ $center->id }}"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3"
                                required>
                            <option value="">Select a Leader</option>
                            @foreach (\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}" {{ $center->leader_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('leader_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('assign-leader-{{ $center->id }}').close()"
                                class="btn-custom bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2 rounded-lg hover:from-gray-600 hover:to-gray-700 flex items-center shadow-md">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </button>
                        <button type="submit"
                                class="btn-custom bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-indigo-700 flex items-center shadow-md">
                            <i class="fas fa-check mr-2"></i>Assign
                        </button>
                    </div>
                </form>
            </dialog>

            <dialog id="add-member-{{ $center->id }}"
                    class="p-6 bg-white rounded-xl shadow-lg max-w-md w-full bg-gradient-to-br from-white to-gray-50 border border-indigo-200 animate__animated animate__zoomIn animate__fastest">
                <h2 class="text-xl font-bold text-indigo-900 mb-4">
                    <i class="fas fa-user-plus mr-2 text-indigo-600"></i>Add Member to {{ $center->name }}
                </h2>
                <form method="POST" action="{{ route('centers.add-member', $center->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="user_id-{{ $center->id }}" class="block text-sm font-medium text-indigo-800">Select Member</label>
                        <select name="user_id" id="user_id-{{ $center->id }}"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3"
                                required>
                            <option value="">Select a Member</option>
                            @foreach (\App\Models\User::all() as $user)
                                @if (!$center->members->contains($user))
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('add-member-{{ $center->id }}').close()"
                                class="btn-custom bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2 rounded-lg hover:from-gray-600 hover:to-gray-700 flex items-center shadow-md">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </button>
                        <button type="submit"
                                class="btn-custom bg-gradient-to-r from-green-600 to-teal-600 text-white px-4 py-2 rounded-lg hover:from-green-700 hover:to-teal-700 flex items-center shadow-md">
                            <i class="fas fa-check mr-2"></i>Add
                        </button>
                    </div>
                </form>
            </dialog>

            <dialog id="remove-member-{{ $center->id }}"
                    class="p-6 bg-white rounded-xl shadow-lg max-w-md w-full bg-gradient-to-br from-white to-gray-50 border border-indigo-200 animate__animated animate__zoomIn animate__fastest">
                <h2 class="text-xl font-bold text-indigo-900 mb-4">
                    <i class="fas fa-user-minus mr-2 text-indigo-600"></i>Remove Member from {{ $center->name }}
                </h2>
                <form method="POST" action="{{ route('centers.remove-member', $center->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="mb-4">
                        <label for="user_id-{{ $center->id }}" class="block text-sm font-medium text-indigo-800">Select Member to Remove</label>
                        <select name="user_id" id="user_id-{{ $center->id }}"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3"
                                required>
                            <option value="">Select a Member</option>
                            @foreach ($center->members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('remove-member-{{ $center->id }}').close()"
                                class="btn-custom bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2 rounded-lg hover:from-gray-600 hover:to-gray-700 flex items-center shadow-md">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </button>
                        <button type="submit"
                                class="btn-custom bg-gradient-to-r from-red-600 to-pink-600 text-white px-4 py-2 rounded-lg hover:from-red-700 hover:to-pink-700 flex items-center shadow-md">
                            <i class="fas fa-check mr-2"></i>Remove
                        </button>
                    </div>
                </form>
            </dialog>
        @endforeach
    </div>
@endsection