<div class="sidebar">
    <div class="p-3">
        <!-- Logo -->
        <a href="{{ url('/dashboard') }}" class="logo d-flex align-items-center mb-4 ms-2 mt-2">
            <img src="{{ asset('images/logo-white.png') }}" alt="MediTrack Logo" class="me-2" style="height: 42px; width: auto;">
            MediTrack
        </a>
        
        <!-- Main Navigation -->
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('dashboard.products') }}">
                <i class="fas fa-pills"></i>
                Products
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.prescription*') ? 'active' : '' }}" href="{{ route('dashboard.prescription') }}">
                <i class="fas fa-shopping-cart"></i>
                Prescription
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.users*') ? 'active' : '' }}" href="{{ route('dashboard.users') }}">
                <i class="fas fa-users"></i>
                Users
            </a>
            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('dashboard.profile') }}">
                <i class="fas fa-user"></i>
                Profile
            </a>
        </nav>
    </div>
</div>
