@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Add User')

@section('styles')
<!-- add custom styles here if needed -->
<style>
.add-user-container {
    background: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    padding: 1.5rem;
    margin-top: 1rem;
}

.form-section {
    margin-bottom: 1.5rem;
}

.form-section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e9ecef;
}

.form-label {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.required-field::after {
    content: "*";
    color: var(--danger);
    margin-left: 0.25rem;
}

.form-control {
    border-radius: 0.375rem;
    border: 1px solid #ced4da;
    padding: 0.75rem;
}

.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(43, 126, 193, 0.25);
}

.form-select {
    border-radius: 0.375rem;
    border: 1px solid #ced4da;
    padding: 0.75rem;
}

.form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(43, 126, 193, 0.25);
}

.btn-primary {
    background-color: var(--primary);
    border-color: var(--primary);
    border-radius: 0.375rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
}

.btn-primary:hover {
    background-color: #1e5a96;
    border-color: #1e5a96;
}

/* Modal Styles */
.modal-content {
    border-radius: 0.5rem;
    border: none;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.modal-header {
    background-color: var(--primary);
    color: white;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
    padding: 1rem 1.5rem;
}

.modal-title {
    font-weight: 600;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e9ecef;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
    margin-bottom: 1.5rem;
}

.breadcrumb-item a {
    color: var(--primary);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #6c757d;
}

/* Validation Styles */
.is-invalid {
    border-color: var(--danger) !important;
}

.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: var(--danger);
}

.was-validated .form-control:invalid ~ .invalid-feedback,
.form-control.is-invalid ~ .invalid-feedback {
    display: block;
}
</style>
@endsection

@section('content')
<!-- make add user form here -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Users</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Add Users
        </li>
    </ol>
</nav>

            <div class="add-user-container">
                <h4 class="mb-4" style="color: var(--dark);">Add New User</h4>

                <form action="{{ route('dashboard.users.add.post') }}" method="POST" id="addUserForm" class="needs-validation" novalidate>
                    @csrf
                    
                    <!-- Name Section -->
                    <div class="form-section">
                        <h5 class="form-section-title">Name <span class="required-field"></span></h5>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required minlength="2">
                            <div class="invalid-feedback" id="nameError">
                                Please provide a valid name (at least 2 characters).
                            </div>
                        </div>
                    </div>

                    <!-- Email Section -->
                    <div class="form-section">
                        <h5 class="form-section-title">Email <span class="required-field"></span></h5>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                            <div class="invalid-feedback" id="emailError">
                                Please provide a valid email address.
                            </div>
                        </div>
                    </div>

                    <!-- Role Section (Dropdown) -->
                   <div class="form-section">
                        <h5 class="form-section-title">Role <span class="required-field"></span></h5>
                        <div class="mb-3">
                            <select class="form-select" id="role" name="role" required>
                                <option value="" selected disabled>Select Role</option>
                                @if(isset($roles) && is_array($roles))
                                    @foreach($roles as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                @else
                                    <!-- Fallback if no roles are provided -->
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                
                                @endif
                            </select>
                            <div class="invalid-feedback" id="roleError">
                                Please select a role.
                            </div>
                        </div>
                    </div>
                    <!-- Password Section -->
                    <div class="form-section">
                        <h5 class="form-section-title">Password <span class="required-field"></span></h5>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required minlength="8">
                            <div class="invalid-feedback" id="passwordError">
                                Please provide a valid password (at least 8 characters).
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <h5 class="form-section-title">Confirm Password <span class="required-field"></span></h5>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="confirmPassword" name="password_confirmation"" placeholder="Confirm password" required minlength="8">
                            <div class="invalid-feedback" id="confirmPasswordError">
                                Please provide a valid password (at least 8 characters).
                            </div>
                        </div>
                    </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="button" class="btn btn-primary" id="validateAndOpenModal">
                            Add User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Admin Authentication Modal -->
<div class="modal fade" id="adminAuthModal" tabindex="-1" aria-labelledby="adminAuthModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminAuthModalLabel">Admin Authentication Required</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>To add a new user, please confirm your admin password:</p>
                <div class="mb-3">
                    <label for="adminPassword" class="form-label">Admin Password</label>
                    <input type="password" class="form-control" id="adminPassword" placeholder="Enter your password" required>
                    <div id="passwordError" class="invalid-feedback">
                        Password cannot be empty.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAddUser">Confirm & Add User</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Success</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>User added successfully!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- add custom scripts here if needed -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const adminAuthModal = document.getElementById('adminAuthModal');
    const adminPasswordInput = document.getElementById('adminPassword');
    const passwordError = document.getElementById('passwordError');
    const confirmAddUserBtn = document.getElementById('confirmAddUser');
    const addUserForm = document.getElementById('addUserForm');
    const validateAndOpenModalBtn = document.getElementById('validateAndOpenModal');
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    const authModal = new bootstrap.Modal(adminAuthModal);
    
    // Form validation function
    function validateForm() {
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const roleSelect = document.getElementById('role');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        let isValid = true;
        
        // Reset validation states
        addUserForm.classList.remove('was-validated');
        nameInput.classList.remove('is-invalid');
        emailInput.classList.remove('is-invalid');
        roleSelect.classList.remove('is-invalid');
        password.classList.remove('is-invalid');
        confirmPassword.classList.remove('is-invalid');
        
        // Validate name
        if (!nameInput.value.trim() || nameInput.value.trim().length < 2) {
            nameInput.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validate email
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailInput.value || !emailRegex.test(emailInput.value)) {
            emailInput.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validate role
        if (!roleSelect.value) {
            roleSelect.classList.add('is-invalid');
            isValid = false;
        }
        // Validate password
        if (!password.value || password.value.length < 8) { 
            password.classList.add('is-invalid');
            document.getElementById('passwordError').textContent = 'Password must be at least 8 characters long.';
            isValid = false;
        }

        // Validate confirm password
        if (!confirmPassword.value || confirmPassword.value.length < 8) { 
            confirmPassword.classList.add('is-invalid');
            document.getElementById('confirmPasswordError').textContent = 'Confirm password must be at least 8 characters.';
            isValid = false;
        }

        // Check if password and confirm password match
        if (password.value && confirmPassword.value && password.value !== confirmPassword.value) {
            confirmPassword.classList.add('is-invalid');
            document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
            isValid = false;
        }
        
        if (!isValid) {
            addUserForm.classList.add('was-validated');
            return false;
        }
        
        return true;
    }
    
    // Real-time email validation
    document.getElementById('email').addEventListener('blur', function() {
        const emailInput = this;
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        
        if (emailInput.value && !emailRegex.test(emailInput.value)) {
            emailInput.classList.add('is-invalid');
            document.getElementById('emailError').textContent = 'Please enter a valid email address.';
        } else {
            emailInput.classList.remove('is-invalid');
        }
    });
    
    // Real-time name validation
    document.getElementById('name').addEventListener('blur', function() {
        const nameInput = this;
        
        if (nameInput.value && nameInput.value.trim().length < 2) {
            nameInput.classList.add('is-invalid');
            document.getElementById('nameError').textContent = 'Name must be at least 2 characters long.';
        } else {
            nameInput.classList.remove('is-invalid');
        }
    });
    
    // Real-time role validation
    document.getElementById('role').addEventListener('change', function() {
        const roleSelect = this;
        
        if (!roleSelect.value) {
            roleSelect.classList.add('is-invalid');
        } else {
            roleSelect.classList.remove('is-invalid');
        }
    });
    
    // Validate form and open modal
    validateAndOpenModalBtn.addEventListener('click', function() {
        if (validateForm()) {
            authModal.show();
        }
    });
    
    // Clear password field when modal is shown
    adminAuthModal.addEventListener('show.bs.modal', function () {
        adminPasswordInput.value = '';
        adminPasswordInput.classList.remove('is-invalid');
        passwordError.style.display = 'none';
    });
    
    // Handle confirmation button click
    confirmAddUserBtn.addEventListener('click', function() {
        const password = adminPasswordInput.value;
        
        // Simple validation
        if (password === '') {
            adminPasswordInput.classList.add('is-invalid');
            passwordError.style.display = 'block';
            passwordError.textContent = 'Password cannot be empty';
            return;
        }
        
        // Simulate authentication (no API call)
        // For demo purposes, we'll use a simple check
        const isAuthenticated = (password === 'admin123');
        
        if (isAuthenticated) {
        // Close modal
        authModal.hide();

        // Remove the preventDefault listener
        addUserForm.removeEventListener('submit', preventFormSubmit);

        // Submit the form
        addUserForm.submit();
n
        } else {
            adminPasswordInput.classList.add('is-invalid');
            passwordError.textContent = 'Incorrect password. Please try again.';
            passwordError.style.display = 'block';
        }
    });

    function preventFormSubmit(e) {
        e.preventDefault();
    }
        
    // Form validation
    addUserForm.addEventListener('submit', preventFormSubmit);
});
</script>
@endsection