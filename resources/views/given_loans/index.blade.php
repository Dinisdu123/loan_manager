@extends('layout')

@section('content')
    <div class="container mx-auto px-4 py-6 bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen animate-on-load">
        <div class="flex justify-between items-center mb-6 animate__animated animate__fadeIn animate__fastest">
            <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 drop-shadow-md">
                <i class="fas fa-clipboard-list mr-2 text-indigo-600"></i>Loan Centers
            </h1>
            <a href="{{ route('given_loans.create') }}"
               class="btn-custom bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-700 flex items-center">
                <i class="fas fa-plus-circle mr-2"></i>Assign New Loan
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg shadow-md mb-6 animate__animated animate__bounceIn animate__fastest animate__delay-100ms">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-8">
            <h2 class="text-2xl font-bold text-indigo-800 mb-4 animate__animated animate__fadeIn animate__fastest">
                <i class="fas fa-landmark mr-2"></i>Centers
            </h2>
            @if ($centers->isEmpty())
                <div class="text-center text-gray-600">No centers found.</div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($centers as $center)
                        <div class="bg-white rounded-xl shadow-lg p-4 border border-indigo-200 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeInUp animate__fastest animate__delay-200ms">
                            <h3 class="text-lg font-semibold text-indigo-600">{{ $center->name }}</h3>
                            <a href="{{ route('given_loans.center_members', $center->id) }}"
                               class="mt-2 btn-custom bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-blue-700 flex items-center w-full justify-center">
                                <i class="fas fa-arrow-right mr-2"></i>Go
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection