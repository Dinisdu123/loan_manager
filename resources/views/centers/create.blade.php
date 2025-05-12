@extends('layout')

@section('content')
    <div class="container mx-auto px-4 py-6 bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen animate-on-load">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6 animate__animated animate__fadeIn animate__fastest">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 drop-shadow-md">
                <i class="fas fa-building mr-2 text-indigo-600"></i>Create New Center
            </h1>
            <a href="{{ route('centers.index') }}"
               class="btn-custom bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-gray-600 hover:to-gray-700 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Back to Centers
            </a>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg shadow-md mb-6 animate__animated animate__bounceIn animate__fastest animate__delay-100ms">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 max-w-lg mx-auto card-hover bg-gradient-to-br from-white to-gray-50 border border-indigo-200 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeInUp animate__fastest animate__delay-200ms">
            <form method="POST" action="{{ route('centers.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-indigo-800">Center Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nickname" class="block text-sm font-medium text-indigo-800">Nickname</label>
                    <input type="text" name="nickname" id="nickname" value="{{ old('nickname') }}"
                           class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3"
                           required>
                    @error('nickname')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('centers.index') }}"
                       class="btn-custom bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-gray-600 hover:to-gray-700 flex items-center">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit"
                            class="btn-custom bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-700 flex items-center">
                        <i class="fas fa-check mr-2"></i>Create Center
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection