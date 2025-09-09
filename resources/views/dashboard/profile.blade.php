@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Profile')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>

    <!-- Page Title -->
    <h1 class="h3 mb-4 font-weight-semibold">Profile</h1>

    <!-- Profile Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <!-- Profile Header -->
            <div class="row align-items-center mb-4">
                <div class="col-auto">
                    <img src="{{ $user['avatar'] ?? asset('images/default-profile-icon.svg') }}" 
                         alt="{{ $user['name'] }}" 
                         class="rounded-circle"
                         style="width: 64px; height: 64px; object-fit: cover;">
                </div>
                <div class="col">
                    <h4 class="mb-1 font-weight-semibold">{{ $user['name'] }}</h4>
                    <p class="text-muted mb-0">{{ $user['email'] }}</p>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs border-bottom" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" 
                       id="about-tab" 
                       data-toggle="tab" 
                       href="#about" 
                       role="tab" 
                       aria-controls="about" 
                       aria-selected="true"
                       style="color: #17a2b8; border-bottom: 2px solid #17a2b8;">
                        About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" 
                       id="password-tab" 
                       data-toggle="tab" 
                       href="#password" 
                       role="tab" 
                       aria-controls="password" 
                       aria-selected="false">
                        Password
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Personal Details Card (About Tab Content) -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <!-- Section Header -->
                    <div class="row align-items-center mb-4">
                        <div class="col">
                            <h5 class="mb-0">Personal Details</h5>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-secondary btn-sm" aria-label="Edit personal details">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                Edit
                            </button>
                        </div>
                    </div>

                    <!-- Personal Details Rows -->
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <span class="text-muted">Name</span>
                        </div>
                        <div class="col-sm-9">
                            <span class="text-body">{{ $user['name'] }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <span class="text-muted">Email ID</span>
                        </div>
                        <div class="col-sm-9">
                            <span class="text-body">{{ $user['email'] }}</span>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-sm-3">
                            <span class="text-muted">User Role</span>
                        </div>
                        <div class="col-sm-9">
                            <span class="text-body">{{ $user['role'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Tab Content -->
        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="mb-4">Change Password</h5>
                    
                    <form id="passwordForm" class="needs-validation" novalidate>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="currentPassword" class="col-form-label text-muted">Current Password</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" 
                                       class="form-control" 
                                       id="currentPassword" 
                                       placeholder="Enter your current password"
                                       required>
                                <div class="invalid-feedback">
                                    Please enter your current password.
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="newPassword" class="col-form-label text-muted">New Password</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" 
                                       class="form-control" 
                                       id="newPassword" 
                                       placeholder="Enter new password"
                                       minlength="8"
                                       required>
                                <div class="invalid-feedback">
                                    Password must be at least 8 characters long.
                                </div>
                                <small class="form-text text-muted">
                                    Password must be at least 8 characters long.
                                </small>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-sm-3">
                                <label for="confirmPassword" class="col-form-label text-muted">Confirm New Password</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" 
                                       class="form-control" 
                                       id="confirmPassword" 
                                       placeholder="Confirm new password"
                                       required>
                                <div class="invalid-feedback">
                                    Please confirm your new password.
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Minimal scoped styles for exact design match */
.nav-tabs .nav-link.active {
    background-color: rgba(23, 162, 184, 0.1);
    border-color: transparent transparent #17a2b8 transparent;
    color: #17a2b8 !important;
    font-weight: 500;
}

.nav-tabs .nav-link:hover {
    border-color: transparent;
    color: #17a2b8;
}

.nav-tabs {
    border-bottom: 1px solid #dee2e6;
}

.font-weight-semibold {
    font-weight: 600;
}

.btn-primary {
    background-color: #17a2b8;
    border-color: #17a2b8;
}

.btn-primary:hover {
    background-color: #138496;
    border-color: #117a8b;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabLinks = document.querySelectorAll('[data-toggle="tab"]');
    
    tabLinks.forEach(function(tabLink) {
        tabLink.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs and panes
            tabLinks.forEach(function(link) {
                link.classList.remove('active');
                link.setAttribute('aria-selected', 'false');
                link.style.color = '';
                link.style.borderBottom = '';
                link.style.backgroundColor = '';
            });
            
            document.querySelectorAll('.tab-pane').forEach(function(pane) {
                pane.classList.remove('show', 'active');
            });
            
            // Add active class to clicked tab
            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');
            this.style.color = '#17a2b8';
            this.style.borderBottom = '2px solid #17a2b8';
            this.style.backgroundColor = 'rgba(23, 162, 184, 0.1)';
            
            // Show corresponding pane
            const targetPane = document.querySelector(this.getAttribute('href'));
            if (targetPane) {
                targetPane.classList.add('show', 'active');
            }
        });
    });
    
    // Handle URL hash on page load
    if (window.location.hash === '#password') {
        document.getElementById('password-tab').click();
    }
    
    // Password form validation
    const passwordForm = document.getElementById('passwordForm');
    
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const currentPassword = document.getElementById('currentPassword');
            const newPassword = document.getElementById('newPassword');
            const confirmPassword = document.getElementById('confirmPassword');

            // Reset previous validation states
            [currentPassword, newPassword, confirmPassword].forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
            });

            let isValid = true;

            // Validate current password
            if (!currentPassword.value.trim()) {
                currentPassword.classList.add('is-invalid');
                isValid = false;
            } else {
                currentPassword.classList.add('is-valid');
            }

            // Validate new password
            if (!newPassword.value.trim() || newPassword.value.length < 8) {
                newPassword.classList.add('is-invalid');
                isValid = false;
            } else {
                newPassword.classList.add('is-valid');
            }

            // Validate confirm password
            if (!confirmPassword.value.trim() || confirmPassword.value !== newPassword.value) {
                confirmPassword.classList.add('is-invalid');
                if (confirmPassword.value !== newPassword.value) {
                    confirmPassword.nextElementSibling.textContent = 'Passwords do not match.';
                }
                isValid = false;
            } else {
                confirmPassword.classList.add('is-valid');
            }

            if (isValid) {
                // Show loading state
                const submitBtn = passwordForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = 'Updating...';
                submitBtn.disabled = true;

                // Simulate API call
                setTimeout(() => {
                    // Reset form
                    passwordForm.reset();
                    [currentPassword, newPassword, confirmPassword].forEach(input => {
                        input.classList.remove('is-invalid', 'is-valid');
                    });

                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;

                    // Show success message
                    alert('Password updated successfully!');
                }, 2000);
            }

            passwordForm.classList.add('was-validated');
        });

        // Real-time password confirmation validation
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && newPassword !== confirmPassword) {
                this.classList.add('is-invalid');
                this.nextElementSibling.textContent = 'Passwords do not match.';
            } else if (confirmPassword && newPassword === confirmPassword) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    }
});
</script>
@endsection