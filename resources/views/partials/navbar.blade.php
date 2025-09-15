<div class="top-navbar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <!-- Mobile sidebar toggle -->
                <button class="btn btn-link d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="mb-0 text-dark">@yield('page-title', 'Dashboard')</h4>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-end">
                    
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <a class="text-decoration-none btn btn-link d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <span class="text-dark fs-5" id="navbar-user-name">{{ auth()->check() ? auth()->user()->name : 'Guest' }}&nbsp;</span><span class="fs-6" id="navbar-user-role">({{ auth()->check() ? auth()->user()->role : 'guest' }})</span>
                            <i class="fas fa-chevron-down ms-2 text-muted"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard.profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: left;">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
