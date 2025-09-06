<div class="sidebar">
    <div class="p-3">
        <!-- Logo -->
        <a href="{{ url('/dashboard') }}" class="logo d-flex align-items-center mb-4">
            <i class="fas fa-plus-circle"></i>
            MediTrack
        </a>
        
        <!-- Main Navigation -->
        <div class="mb-3">
            <small class="text-light text-uppercase fw-bold">Main</small>
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="#categories">
                <i class="fas fa-tags"></i>
                Categories
            </a>
            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="#products">
                <i class="fas fa-pills"></i>
                Products
            </a>
            <a class="nav-link {{ request()->routeIs('sale.*') ? 'active' : '' }}" href="#sale">
                <i class="fas fa-shopping-cart"></i>
                Sale
            </a>
            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="#users">
                <i class="fas fa-users"></i>
                Users
            </a>
            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="#profile">
                <i class="fas fa-user"></i>
                Profile
            </a>
        </nav>
    </div>
</div>
