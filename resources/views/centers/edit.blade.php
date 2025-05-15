@extends('layout')

@section('content')
    <div class="container mx-auto px-4 py-6 bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen animate-on-load">
        
        <div class="flex justify-between items-center mb-6 animate__animated animate__fadeIn animate__fastest">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 drop-shadow-md">
                <i class="fas fa-building mr-2 text-indigo-600"></i>Edit Center: {{ $center->name }}
            </h1>
            <a href="{{ route('centers.details', $center->id) }}"
               class="btn-custom bg-gradient-to-r from-gray-600 to-gray-800 text-white px-6 py-3 rounded-lg shadow-md hover:from-gray-700 hover:to-gray-900 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Back to Center Details
            </a>
        </div>

       
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover bg-gradient-to-br from-white to-gray-50 border border-indigo-200 animate__animated animate__fadeInUp animate__fastest">
            <form method="POST" action="{{ route('centers.update', $center->id) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-indigo-800">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $center->name) }}"
                               class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    
                    <div class="mb-4">
                        <label for="nickname" class="block text-sm font-medium text-indigo-800">Nickname</label>
                        <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $center->nickname) }}"
                               class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3"
                               required>
                        @error('nickname')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                   
                    <div class="mb-4">
                        <label for="leader_id" class="block text-sm font-medium text-indigo-800">Leader</label>
                        <select name="leader_id" id="leader_id"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3">
                            <option value="">None</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $center->leader_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('leader_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

               
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('centers.details', $center->id) }}"
                       class="btn-custom bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2 rounded-lg hover:from-gray-600 hover:to-gray-700 flex items-center shadow-md">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit"
                            class="btn-custom bg-gradient-to-r from-green-600 to-teal-600 text-white px-4 py-2 rounded-lg hover:from-green-700 hover:to-teal-700 flex items-center shadow-md">
                        <i class="fas fa-check mr-2"></i>Update Center
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection