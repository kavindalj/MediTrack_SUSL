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
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="editPersonalDetailsBtn" aria-label="Edit personal details">
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
                            <span class="text-body" id="displayName">{{ $user['name'] }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <span class="text-muted">Email ID</span>
                        </div>
                        <div class="col-sm-9">
                            <span class="text-body" id="displayEmail">{{ $user['email'] }}</span>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-sm-3">
                            <span class="text-muted">User Role</span>
                        </div>
                        <div class="col-sm-9">
                            <span class="text-body" id="displayRole">{{ $user['role'] }}</span>
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

<!-- Edit Personal Details Modal -->
<div class="modal fade" id="editPersonalDetailsModal" tabindex="-1" role="dialog" aria-labelledby="editPersonalDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPersonalDetailsModalLabel">Edit Personal Details</h5>
                <button type="button" class="close" id="closeModalBtn" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPersonalDetailsForm" class="needs-validation" novalidate>
                    <div class="form-group mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" 
                               class="form-control" 
                               id="editName" 
                               value="{{ $user['name'] }}"
                               required>
                        <div class="invalid-feedback">
                            Please enter your name.
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="editEmail" class="form-label">Email ID</label>
                        <input type="email" 
                               class="form-control" 
                               id="editEmail" 
                               value="{{ $user['email'] }}"
                               required>
                        <div class="invalid-feedback">
                            Please enter a valid email address.
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="editRole" class="form-label">User Role</label>
                        <select class="form-control" id="editRole" required>
                            <option value="admin" {{ $user['role'] === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="doctor" {{ $user['role'] === 'doctor' ? 'selected' : '' }}>Doctor</option>
                            <option value="pharmacist" {{ $user['role'] === 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                            <option value="supplier" {{ $user['role'] === 'supplier' ? 'selected' : '' }}>Supplier</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a user role.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelModalBtn">Cancel</button>
                <button type="button" class="btn btn-primary" id="savePersonalDetailsBtn">Save Changes</button>
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

/* Modal styling */
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1040;
    width: 100vw;
    height: 100vh;
    background-color: #000;
}

.modal-backdrop.fade {
    opacity: 0;
}

.modal-backdrop.show {
    opacity: 0.5;
}

.modal.show {
    display: block !important;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    width: 100%;
    height: 100%;
    overflow: hidden;
    outline: 0;
}

.modal-dialog {
    position: relative;
    width: auto;
    margin: 0.5rem;
    pointer-events: none;
}

@media (min-width: 576px) {
    .modal-dialog {
        max-width: 500px;
        margin: 1.75rem auto;
    }
}

body.modal-open {
    overflow: hidden;
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
    
    // Personal Details Edit functionality
    const editPersonalDetailsBtn = document.getElementById('editPersonalDetailsBtn');
    const savePersonalDetailsBtn = document.getElementById('savePersonalDetailsBtn');
    const editPersonalDetailsForm = document.getElementById('editPersonalDetailsForm');
    const editPersonalDetailsModal = document.getElementById('editPersonalDetailsModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    
    // Modal functions
    function showModal() {
        editPersonalDetailsModal.style.display = 'block';
        editPersonalDetailsModal.classList.add('show');
        document.body.classList.add('modal-open');
        
        // Add backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        backdrop.id = 'modalBackdrop';
        document.body.appendChild(backdrop);
    }
    
    function hideModal() {
        editPersonalDetailsModal.style.display = 'none';
        editPersonalDetailsModal.classList.remove('show');
        document.body.classList.remove('modal-open');
        
        // Remove backdrop
        const backdrop = document.getElementById('modalBackdrop');
        if (backdrop) {
            backdrop.remove();
        }
        
        // Reset form validation states
        const editName = document.getElementById('editName');
        const editEmail = document.getElementById('editEmail');
        const editRole = document.getElementById('editRole');
        
        [editName, editEmail, editRole].forEach(input => {
            input.classList.remove('is-invalid', 'is-valid');
        });
        editPersonalDetailsForm.classList.remove('was-validated');
    }
    
    // Event listeners
    if (editPersonalDetailsBtn) {
        editPersonalDetailsBtn.addEventListener('click', function() {
            showModal();
        });
    }
    
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            hideModal();
        });
    }
    
    if (cancelModalBtn) {
        cancelModalBtn.addEventListener('click', function() {
            hideModal();
        });
    }
    
    // Close modal when clicking outside
    if (editPersonalDetailsModal) {
        editPersonalDetailsModal.addEventListener('click', function(e) {
            if (e.target === editPersonalDetailsModal) {
                hideModal();
            }
        });
    }
    
    if (savePersonalDetailsBtn && editPersonalDetailsForm) {
        savePersonalDetailsBtn.addEventListener('click', function() {
            const editName = document.getElementById('editName');
            const editEmail = document.getElementById('editEmail');
            const editRole = document.getElementById('editRole');
            
            // Reset previous validation states
            [editName, editEmail, editRole].forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
            });
            
            let isValid = true;
            
            // Validate name
            if (!editName.value.trim()) {
                editName.classList.add('is-invalid');
                isValid = false;
            } else {
                editName.classList.add('is-valid');
            }
            
            // Validate email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!editEmail.value.trim() || !emailRegex.test(editEmail.value)) {
                editEmail.classList.add('is-invalid');
                isValid = false;
            } else {
                editEmail.classList.add('is-valid');
            }
            
            // Validate role
            if (!editRole.value) {
                editRole.classList.add('is-invalid');
                isValid = false;
            } else {
                editRole.classList.add('is-valid');
            }
            
            if (isValid) {
                // Show loading state
                const originalText = savePersonalDetailsBtn.innerHTML;
                savePersonalDetailsBtn.innerHTML = 'Saving...';
                savePersonalDetailsBtn.disabled = true;
                
                // Simulate API call
                setTimeout(() => {
                    // Update the display values
                    document.getElementById('displayName').textContent = editName.value;
                    document.getElementById('displayEmail').textContent = editEmail.value;
                    
                    // Format role for display
                    const roleDisplayMap = {
                        'admin': 'Admin',
                        'doctor': 'Doctor',
                        'pharmacist': 'Pharmacist',
                        'supplier': 'Supplier'
                    };
                    document.getElementById('displayRole').textContent = roleDisplayMap[editRole.value] || editRole.value;
                    
                    // Update profile header
                    const profileNameHeader = document.querySelector('.card-body h4');
                    const profileEmailHeader = document.querySelector('.card-body p.text-muted');
                    if (profileNameHeader) profileNameHeader.textContent = editName.value;
                    if (profileEmailHeader) profileEmailHeader.textContent = editEmail.value;
                    
                    // Reset button
                    savePersonalDetailsBtn.innerHTML = originalText;
                    savePersonalDetailsBtn.disabled = false;
                    
                    // Close modal
                    hideModal();
                    
                    // Show success message
                    alert('Personal details updated successfully!');
                }, 1500);
            }
            
            editPersonalDetailsForm.classList.add('was-validated');
        });
    }
});
</script>
@endsection