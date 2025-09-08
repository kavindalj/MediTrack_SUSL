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
                    <!-- Search -->
                    <div class="me-3">
                        <form class="d-flex">
                            <input class="form-control form-control-sm" type="search" placeholder="Search..." aria-label="Search">
                        </form>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <a class="text-decoration-none btn btn-link d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <span class="text-dark fs-5">Kamal&nbsp;</span><span class="fs-6">(admin)</span>
                            <i class="fas fa-chevron-down ms-2 text-muted"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
