@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Add User')

@section('styles')

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
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Users</li>
                </ol>
            </nav>

            <div class="add-user-container">
                <h4 class="mb-4" style="color: var(--dark);">Add New User</h4>

                <form id="addUserForm">
                    @csrf
                    
                    <!-- Name Section -->
                    <div class="form-section">
                        <h5 class="form-section-title">Name <span class="required-field"></span></h5>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
                        </div>
                    </div>

                    <!-- Email Section -->
                    <div class="form-section">
                        <h5 class="form-section-title">Email <span class="required-field"></span></h5>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                        </div>
                    </div>

                    <!-- Role Section (Dropdown) -->
                    <div class="form-section">
                        <h5 class="form-section-title">Role <span class="required-field"></span></h5>
                        <div class="mb-3">
                            <select class="form-select" id="role" name="role" required>
                                <option value="">Select a role</option>
                                @if(isset($roles) && is_array($roles))
                                    @foreach($roles as $value => $label)
                                        <option value="{{ $value }}" {{ $value == 'admin' ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                @else
                                    <!-- Fallback if no roles are provided -->
                                    <option value="admin" selected>Admin</option>
                                    <option value="pharmacist">Pharmacist</option>
                                    <option value="salesperson">Salesperson</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminAuthModal">
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
                    <input type="password" class="form-control" id="adminPassword" placeholder="Enter your password">
                    <div id="passwordError" class="text-danger mt-1" style="display: none;">Incorrect password. Please try again.</div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const adminAuthModal = document.getElementById('adminAuthModal');
    const adminPasswordInput = document.getElementById('adminPassword');
    const passwordError = document.getElementById('passwordError');
    const confirmAddUserBtn = document.getElementById('confirmAddUser');
    const addUserForm = document.getElementById('addUserForm');
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    
    // Clear password field when modal is shown
    adminAuthModal.addEventListener('show.bs.modal', function () {
        adminPasswordInput.value = '';
        passwordError.style.display = 'none';
    });
    
    // Handle confirmation button click
    confirmAddUserBtn.addEventListener('click', function() {
        const password = adminPasswordInput.value;
        
        // Simple validation
        if (password === '') {
            passwordError.textContent = 'Password cannot be empty';
            passwordError.style.display = 'block';
            return;
        }
        
        // Simulate authentication (no API call)
        // For demo purposes, we'll use a simple check
        const isAuthenticated = (password === 'admin123');
        
        if (isAuthenticated) {
            // Hide error if shown
            passwordError.style.display = 'none';
            
            // Close the auth modal
            const modal = bootstrap.Modal.getInstance(adminAuthModal);
            modal.hide();
            
            // Show success message
            successModal.show();
            
            // Reset the form
            addUserForm.reset();
            
            // Reset the role dropdown to default
            document.getElementById('role').value = 'admin';
        } else {
            passwordError.textContent = 'Incorrect password. Please try again.';
            passwordError.style.display = 'block';
        }
    });
    
    // Form validation
    addUserForm.addEventListener('submit', function(e) {
        e.preventDefault();
    });
});
</script>
@endsection