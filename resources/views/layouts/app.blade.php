<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MediTrack Dashboard')</title>
    
    <!-- Bootstrap CSS (Local) -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom common CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('partials.sidebar')
        
        <!-- Main Content -->
        <div class="main-content flex-fill">
            <!-- Top Navigation -->
            @include('partials.navbar')
            
            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <!-- jQuery  -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    <!-- Bootstrap JS (Local) -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Custom JS -->
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
            
            // Handle sidebar active states for products page
            const currentPath = window.location.pathname;
            if (currentPath.includes('/dashboard/products')) {
                // Remove active class from all nav links
                document.querySelectorAll('.sidebar .nav-link').forEach(link => {
                    link.classList.remove('active');
                });
                
                // Add active class to products link
                const productsLink = document.querySelector('.sidebar .nav-link[href*="/dashboard/products"]');
                if (productsLink) {
                    productsLink.classList.add('active');
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')
</body>
</html>
