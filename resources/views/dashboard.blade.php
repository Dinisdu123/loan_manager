@extends('layout')

@section('content')
    <div class="container mx-auto px-4 py-8 bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen animate-on-load">
    
        <h1 class="text-4xl md:text-5xl font-extrabold text-indigo-900 text-center mb-10 drop-shadow-md animate__animated animate__zoomIn animate__faster">
            <i class="fas fa-tachometer-alt mr-2 text-indigo-600"></i>Loan Management System
        </h1>

      
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 animate__animated animate__fadeInUp animate__faster animate__delay-100ms">
           
            <div class="bg-white rounded-xl shadow-lg p-5 card-hover bg-gradient-to-br from-indigo-100 to-blue-100 hover:shadow-xl transition-all duration-300">
                <h2 class="text-lg font-bold text-indigo-800 mb-3 flex items-center">
                    <i class="fas fa-money-check-alt mr-2 text-xl text-indigo-600"></i>Loans & Payments
                </h2>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('loans.index') }}"
                       class="btn-custom bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-blue-700 flex items-center shadow-md">
                        <i class="fas fa-list mr-2"></i>View My Loans
                    </a>
                    <a href="{{ route('loans.create') }}"
                       class="btn-custom bg-gradient-to-r from-green-500 to-teal-500 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-teal-600 flex items-center shadow-md">
                        <i class="fas fa-plus-circle mr-2"></i>Add New Loan
                    </a>
                    <a href="{{ route('payments.index') }}"
                       class="btn-custom bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-4 py-2 rounded-lg hover:from-blue-600 hover:to-cyan-600 flex items-center shadow-md">
                        <i class="fas fa-money-bill mr-2"></i>View Payments
                    </a>
                </div>
            </div>

          
            <div class="bg-white rounded-xl shadow-lg p-5 card-hover bg-gradient-to-br from-blue-100 to-purple-100 hover:shadow-xl transition-all duration-300">
                <h2 class="text-lg font-bold text-indigo-800 mb-3 flex items-center">
                    <i class="fas fa-users mr-2 text-xl text-blue-600"></i>Users
                </h2>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('users.index') }}"
                       class="btn-custom bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-indigo-700 flex items-center shadow-md">
                        <i class="fas fa-users mr-2"></i>View Users
                    </a>
                    <a href="{{ route('users.create') }}"
                       class="btn-custom bg-gradient-to-r from-green-500 to-lime-500 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-lime-600 flex items-center shadow-md">
                        <i class="fas fa-user-plus mr-2"></i>Add Users
                    </a>
                </div>
            </div>

           
            <div class="bg-white rounded-xl shadow-lg p-5 card-hover bg-gradient-to-br from-purple-100 to-pink-100 hover:shadow-xl transition-all duration-300">
                <h2 class="text-lg font-bold text-indigo-800 mb-3 flex items-center">
                    <i class="fas fa-building mr-2 text-xl text-purple-600"></i>Centers
                </h2>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('centers.index') }}"
                       class="btn-custom bg-gradient-to-r from-purple-600 to-violet-600 text-white px-4 py-2 rounded-lg hover:from-purple-700 hover:to-violet-700 flex items-center shadow-md">
                        <i class="fas fa-building mr-2"></i>View Centers
                    </a>
                    <a href="{{ route('centers.create') }}"
                       class="btn-custom bg-gradient-to-r from-teal-500 to-cyan-500 text-white px-4 py-2 rounded-lg hover:from-teal-600 hover:to-cyan-600 flex items-center shadow-md">
                        <i class="fas fa-plus-circle mr-2"></i>Add New Center
                    </a>
                </div>
            </div>

            
            <div class="bg-white rounded-xl shadow-lg p-5 card-hover bg-gradient-to-br from-orange-100 to-red-100 hover:shadow-xl transition-all duration-300">
                <h2 class="text-lg font-bold text-indigo-800 mb-3 flex items-center">
                    <i class="fas fa-clipboard-list mr-2 text-xl text-orange-600"></i>Given Loans
                </h2>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('given_loans.index') }}"
                       class="btn-custom bg-gradient-to-r from-orange-500 to-amber-500 text-white px-4 py-2 rounded-lg hover:from-orange-600 hover:to-amber-600 flex items-center shadow-md">
                        <i class="fas fa-clipboard-list mr-2"></i>View Given Loans
                    </a>
                    <a href="{{ route('given_loans.create') }}"
                       class="btn-custom bg-gradient-to-r from-red-500 to-pink-500 text-white px-4 py-2 rounded-lg hover:from-red-600 hover:to-pink-600 flex items-center shadow-md">
                        <i class="fas fa-plus-circle mr-2"></i>Add New Given Loan
                    </a>
                </div>
            </div>
        </div>

      
        <div class="mt-10 animate__animated animate__fadeInUp animate__faster animate__delay-300ms">
            <h2 class="text-2xl font-bold text-indigo-800 text-center mb-5 drop-shadow-sm">
                Nearest Upcoming Payment
            </h2>
            @if ($nearestPayment)
                @php
                    $isOverdue = \Carbon\Carbon::parse($nearestPayment->payment_date)->isBefore(now());
                @endphp
                <div class="card-hover bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-lg max-w-md mx-auto border border-indigo-200 hover:shadow-xl transition-all duration-300 animate__animated animate__bounceIn animate__faster animate__delay-400ms">
                    <h3 class="text-xl font-semibold {{ $isOverdue ? 'text-red-600' : 'text-indigo-600' }} mb-3">
                        Payment for {{ $nearestPayment->loan->lender_name }}
                    </h3>
                    <div class="text-gray-700 {{ $isOverdue ? 'text-red-600' : '' }} space-y-1 text-sm">
                        <p><strong>Amount:</strong> {{ number_format($nearestPayment->amount, 2) }}</p>
                        <p><strong>Date:</strong> {{ $nearestPayment->payment_date->format('Y-m-d') }}</p>
                        <p><strong>Status:</strong> {{ $isOverdue ? 'Overdue' : 'Pending' }}</p>
                    </div>
                    <form action="{{ route('payments.markPaid', $nearestPayment) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit"
                                class="btn-custom bg-gradient-to-r from-green-500 to-teal-500 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-teal-600 flex items-center mx-auto shadow-md">
                            <i class="fas fa-check-circle mr-2"></i>Mark as Paid
                        </button>
                    </form>
                </div>
            @else
                <div class="card-hover bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-lg max-w-md mx-auto border border-indigo-200 text-gray-600 text-center animate__animated animate__fadeIn animate__faster animate__delay-400ms">
                    No upcoming or overdue payments found.
                </div>
            @endif
        </div>
    </div>
@endsection