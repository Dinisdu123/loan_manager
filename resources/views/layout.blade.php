<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Loan Management System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .btn-custom {
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
        }
        .animate-on-load {
            animation-delay: 0s !important;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
   
    <nav class="fixed top-0 left-0 w-full bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg z-50 animate__animated animate__fadeInDown animate__faster">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            
            <a href="{{ route('dashboard') }}"
               class="text-2xl font-extrabold text-white flex items-center">
                <i class="fas fa-tachometer-alt mr-2"></i>LMS
            </a>
           
            <div class="flex space-x-4">
                <a href="{{ route('dashboard') }}"
                   class="text-white px-3 py-2 rounded-lg hover:bg-indigo-700 transition-all duration-200 flex items-center">
                    <i class="fas fa-home mr-1"></i>Dashboard
                </a>
                <a href="{{ route('loans.index') }}"
                   class="text-white px-3 py-2 rounded-lg hover:bg-indigo-700 transition-all duration-200 flex items-center">
                    <i class="fas fa-money-check-alt mr-1"></i>Loans
                </a>
                <a href="{{ route('payments.index') }}"
                   class="text-white px-3 py-2 rounded-lg hover:bg-indigo-700 transition-all duration-200 flex items-center">
                    <i class="fas fa-money-bill mr-1"></i>Payments
                </a>
                <a href="{{ route('centers.index') }}"
                   class="text-white px-3 py-2 rounded-lg hover:bg-indigo-700 transition-all duration-200 flex items-center">
                    <i class="fas fa-building mr-1"></i>Centers
                </a>
                <a href="{{ route('given_loans.index') }}"
                   class="text-white px-3 py-2 rounded-lg hover:bg-indigo-700 transition-all duration-200 flex items-center">
                    <i class="fas fa-clipboard-list mr-1"></i>Given Loans
                </a>
            </div>
        </div>
    </nav>

   
    <main class="pt-20"> 
        @yield('content')
    </main>

   
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.animate-on-load');
            elements.forEach(el => el.classList.add('animate__animated'));
        });
    </script>
</body>
</html>