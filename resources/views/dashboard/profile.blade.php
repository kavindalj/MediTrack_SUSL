@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Profile')

@section('styles')
<style>
    /* Minimal scoped styles for exact design match */
    .nav-tabs .nav-link.active {
        background-color: rgba(13, 111, 252, 0.1);
         border-bottom: 2px solid #0d6ffc;
        color: #0d6ffc !important;
        font-weight: 500;
    }

    .nav-tabs .nav-link:hover {
        border-color: transparent;
        color: #0d6ffc;
    }

    .nav-tabs {
        border-bottom: 1px solid #0d6ffc
    }

    .font-weight-semibold {
        font-weight: 600;
    }

    .btn-primary {
        background-color: #0d6ffc;
        border-color: #0d6ffc;
    }

    .btn-prima                    // Update display elements in profile
                    const displayName = document.getElementById('displayName');
                    const displayEmail = document.getElementById('displayEmail');
                    
                    console.log('Display elements found:', {
                        displayName: !!displayName,
                        displayEmail: !!displayEmail
                    });
                    
                    // Update display values in profile
                    if (displayName) displayName.textContent = data.user.name;
                    if (displayEmail) displayEmail.textContent = data.user.email;    background-color: #1163d6;
        border-color: #1163d6;
    }

    .btn-edit {
        background-color: #00bcd4;
        color: white;
    }
    .btn-edit:hover {
        background-color: #00acc1;
        color: white;
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

    /* Success Message Styling */
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .alert-success .fas {
        color: #28a745;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        font-weight: bold;
        line-height: 1;
        color: #155724;
        opacity: 0.7;
        padding: 0;
        cursor: pointer;
    }

    .btn-close:hover {
        opacity: 1;
    }

    /* Error Message Styling */
    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .alert-danger .fas {
        color: #dc3545;
    }

    /* Loading button styles */
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Form validation styles */
    .form-control:invalid {
        border-color: #dc3545;
    }

    .form-control:valid {
        border-color: #28a745;
    }

    .was-validated .form-control:valid {
        border-color: #28a745;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73.82.82.83-.83a.25.25 0 0 1 .41.17l.06.06-.88.88a.5.5 0 0 1-.71 0L1.6 7.12a.25.25 0 0 1 .17-.42l.53.03z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .was-validated .form-control:invalid {
        border-color: #dc3545;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 2.4 2.4M8.2 4.6l-2.4 2.4'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Success Message -->
    <div id="successMessage" class="alert alert-success alert-dismissible fade d-none" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <span id="successMessageText">Personal details updated successfully!</span>
        <button type="button" class="btn-close" aria-label="Close" onclick="hideSuccessMessage()"></button>
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="alert alert-danger alert-dismissible fade d-none" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <span id="errorMessageText">An error occurred!</span>
        <button type="button" class="btn-close" aria-label="Close" onclick="hideErrorMessage()"></button>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #007bff;">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>

    <!-- Profile Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <!-- Profile Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h4 class="mb-1 font-weight-semibold" id="profile-header-name">{{ $userData['name'] }}</h4>
                    <p class="text-muted mb-0" id="profile-header-email">{{ $userData['email'] }}</p>
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
                       style="color: #0d6ffc; border-bottom: 2px solid #0d6ffc;">
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
                            <button type="button" title="Edit" class="btn  btn-edit btn-sm" id="editPersonalDetailsBtn" aria-label="Edit personal details">
                               <i class="fas fa-edit"></i>
                                
                            </button>
                        </div>
                    </div>

                    <!-- Personal Details Rows -->
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <span class="text-muted">Name</span>
                        </div>
                        <div class="col-sm-9">
                            <span class="text-body" id="displayName">{{ $userData['name'] }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <span class="text-muted">Email ID</span>
                        </div>
                        <div class="col-sm-9">
                            <span class="text-body" id="displayEmail">{{ $userData['email'] }}</span>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-sm-3">
                            <span class="text-muted">User Role</span>
                        </div>
                        <div class="col-sm-9">
                            <span class="text-body" id="displayRole">{{ $userData['role'] }}</span>
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
                                       name="new_password_confirmation"
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
                               name="name"
                               value="{{ $userData['name'] }}"
                               minlength="2"
                               maxlength="255"
                               required>
                        <div class="invalid-feedback">
                            Please enter your name (at least 2 characters).
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="editEmail" class="form-label">Email ID</label>
                        <input type="email" 
                               class="form-control" 
                               id="editEmail" 
                               name="email"
                               value="{{ $userData['email'] }}"
                               required>
                        <div class="invalid-feedback">
                            Please enter a valid email address.
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
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== SUCCESS MESSAGE FUNCTIONALITY ==========
    function showSuccessMessage(message = 'Personal details updated successfully!') {
        const successDiv = document.getElementById('successMessage');
        const messageText = document.getElementById('successMessageText');
        
        messageText.textContent = message;
        successDiv.classList.remove('d-none');
        successDiv.classList.add('show');
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            hideSuccessMessage();
        }, 5000);
        
        // Scroll to top to ensure message is visible
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function hideSuccessMessage() {
        const successDiv = document.getElementById('successMessage');
        successDiv.classList.add('d-none');
        successDiv.classList.remove('show');
    }

    function showErrorMessage(message = 'An error occurred!') {
        const errorDiv = document.getElementById('errorMessage');
        const messageText = document.getElementById('errorMessageText');
        
        messageText.textContent = message;
        errorDiv.classList.remove('d-none');
        errorDiv.classList.add('show');
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            hideErrorMessage();
        }, 5000);
        
        // Scroll to top to ensure message is visible
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function hideErrorMessage() {
        const errorDiv = document.getElementById('errorMessage');
        errorDiv.classList.add('d-none');
        errorDiv.classList.remove('show');
    }

    // Make functions available globally for the close buttons
    window.hideSuccessMessage = hideSuccessMessage;
    window.hideErrorMessage = hideErrorMessage;

    // ========== TAB SWITCHING FUNCTIONALITY ==========
    const aboutTab = document.getElementById('about-tab');
    const passwordTab = document.getElementById('password-tab');
    const aboutContent = document.getElementById('about');
    const passwordContent = document.getElementById('password');

    function switchTab(activeTab, activeContent, inactiveTab, inactiveContent) {
        // Update tab appearance
        activeTab.classList.add('active');
        activeTab.style.color = '#0d6ffc';
        activeTab.style.borderBottom = '2px solid #0d6ffc';
        activeTab.setAttribute('aria-selected', 'true');
        
        inactiveTab.classList.remove('active');
        inactiveTab.style.color = '#6c757d';
        inactiveTab.style.borderBottom = 'none';
        inactiveTab.setAttribute('aria-selected', 'false');
        
        // Update content visibility
        activeContent.classList.add('show', 'active');
        inactiveContent.classList.remove('show', 'active');
    }

    aboutTab.addEventListener('click', function(e) {
        e.preventDefault();
        switchTab(aboutTab, aboutContent, passwordTab, passwordContent);
    });

    passwordTab.addEventListener('click', function(e) {
        e.preventDefault();
        switchTab(passwordTab, passwordContent, aboutTab, aboutContent);
    });

    // ========== MODAL FUNCTIONALITY ==========
    const editBtn = document.getElementById('editPersonalDetailsBtn');
    const modal = document.getElementById('editPersonalDetailsModal');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const saveBtn = document.getElementById('savePersonalDetailsBtn');

    // Debug: Check if all elements exist
    console.log('Modal elements found:', {
        editBtn: !!editBtn,
        modal: !!modal,
        closeBtn: !!closeBtn,
        cancelBtn: !!cancelBtn,
        saveBtn: !!saveBtn
    });

    if (!editBtn || !modal || !saveBtn) {
        console.error('Critical modal elements missing!');
        return;
    }

    // Show modal
    editBtn.addEventListener('click', function() {
        console.log('Edit button clicked!');
        // Reset form validation state
        const form = document.getElementById('editPersonalDetailsForm');
        form.classList.remove('was-validated');
        
        // Clear all custom validity
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.setCustomValidity('');
            input.classList.remove('is-invalid');
        });
        
        // Reset form fields to current user data (ensuring fresh data)
        const currentName = document.getElementById('displayName').textContent.trim();
        const currentEmail = document.getElementById('displayEmail').textContent.trim();
        
        document.getElementById('editName').value = currentName;
        document.getElementById('editEmail').value = currentEmail;
        
        // Log current data for debugging
        console.log('Modal opened with current data:', {
            name: currentName,
            email: currentEmail
        });
        
        modal.style.display = 'block';
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        
        // Create backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        backdrop.id = 'modal-backdrop';
        document.body.appendChild(backdrop);
        
        // Focus on the first input
        setTimeout(() => {
            document.getElementById('editName').focus();
        }, 100);
    });

    // Hide modal function
    function hideModal() {
        modal.style.display = 'none';
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
        
        // Remove backdrop
        const backdrop = document.getElementById('modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    }

    // Hide modal events
    closeBtn.addEventListener('click', hideModal);
    cancelBtn.addEventListener('click', hideModal);

    // Click outside modal to close
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            hideModal();
        }
    });

    // Save changes
    saveBtn.addEventListener('click', function() {
        console.log('Save button clicked!');
        const form = document.getElementById('editPersonalDetailsForm');
        
        // Debug: Check if form exists
        if (!form) {
            console.error('Form not found!');
            return;
        }
        
        // Clear previous validation states
        form.classList.remove('was-validated');
        
        // Get form elements
        const nameInput = document.getElementById('editName');
        const emailInput = document.getElementById('editEmail');
        
        // Debug: Check if form elements exist
        console.log('Form elements found:', {
            nameInput: !!nameInput,
            emailInput: !!emailInput
        });
        
        if (!nameInput || !emailInput) {
            console.error('Form elements missing!');
            return;
        }
        
        // Reset custom validity
        nameInput.setCustomValidity('');
        emailInput.setCustomValidity('');
        
        // Custom validation
        let isValid = true;
        
        // Validate name
        if (!nameInput.value.trim() || nameInput.value.trim().length < 2) {
            nameInput.setCustomValidity('Name must be at least 2 characters long');
            isValid = false;
        }
        
        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailInput.value || !emailRegex.test(emailInput.value)) {
            emailInput.setCustomValidity('Please enter a valid email address');
            isValid = false;
        }
        
        console.log('Validation results:', {
            isValid: isValid,
            formValid: form.checkValidity(),
            nameValue: nameInput.value,
            emailValue: emailInput.value
        });
        
        if (form.checkValidity() && isValid) {
            // Get form values first
            const name = nameInput.value.trim();
            const email = emailInput.value.trim();
            
            // Check if data has actually changed
            const currentName = document.getElementById('displayName').textContent.trim();
            const currentEmail = document.getElementById('displayEmail').textContent.trim();
            
            if (name === currentName && email === currentEmail) {
                showErrorMessage('No changes detected. Please modify at least one field before saving.');
                return;
            }
            
            // Show loading state
            const originalText = saveBtn.textContent;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saving...';
            
            // Log the data being sent for debugging
            console.log('Sending profile update:', { name, email });
            
            // Prepare form data with proper validation
            const formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('_token', '{{ csrf_token() }}');
            
            console.log('About to send AJAX request...');
            
            // Send AJAX request
            fetch('{{ route("dashboard.profile.update-profile") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.json().then(data => {
                        console.error('Error response:', data);
                        return Promise.reject(data);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success response:', data);
                if (data.success) {
                    // Check if display elements exist before updating
                    const displayName = document.getElementById('displayName');
                    const displayEmail = document.getElementById('displayEmail');
                    const displayRole = document.getElementById('displayRole');
                    
                    console.log('Display elements found:', {
                        displayName: !!displayName,
                        displayEmail: !!displayEmail,
                        displayRole: !!displayRole
                    });
                    
                    // Update display values in profile
                    if (displayName) displayName.textContent = data.user.name;
                    if (displayEmail) displayEmail.textContent = data.user.email;
                    if (displayRole) displayRole.textContent = data.user.role;
                    
                    // Update profile header name and email
                    const profileHeaderName = document.getElementById('profile-header-name');
                    const profileHeaderEmail = document.getElementById('profile-header-email');
                    if (profileHeaderName) {
                        profileHeaderName.textContent = data.user.name;
                    }
                    if (profileHeaderEmail) {
                        profileHeaderEmail.textContent = data.user.email;
                    }
                    
                    // Update navbar user name
                    const navbarUserName = document.getElementById('navbar-user-name');
                    if (navbarUserName) {
                        navbarUserName.textContent = data.user.name + '\u00A0'; // \u00A0 is non-breaking space
                    }
                    
                    // Hide modal
                    hideModal();
                    
                    // Show success message
                    showSuccessMessage(data.message);
                    
                    console.log('Profile updated successfully in UI');
                } else {
                    showErrorMessage(data.message || 'An error occurred while updating profile.');
                }
            })
            .catch(error => {
                console.error('Catch block error:', error);
                let errorMessage = 'An error occurred while updating profile.';
                
                if (error.message) {
                    errorMessage = error.message;
                } else if (error.errors) {
                    // Handle validation errors
                    if (error.errors.email) {
                        errorMessage = error.errors.email[0];
                        if (emailInput) emailInput.classList.add('is-invalid');
                    } else if (error.errors.name) {
                        errorMessage = error.errors.name[0];
                        if (nameInput) nameInput.classList.add('is-invalid');
                    } else {
                        errorMessage = Object.values(error.errors)[0][0];
                    }
                    form.classList.add('was-validated');
                }
                
                showErrorMessage(errorMessage);
            })
            .finally(() => {
                // Reset button state
                saveBtn.disabled = false;
                saveBtn.textContent = originalText;
            });
        } else {
            form.classList.add('was-validated');
            console.log('Form validation failed');
        }
    });

    // ========== PASSWORD FORM VALIDATION ==========
    const passwordForm = document.getElementById('passwordForm');
    
    passwordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        // Reset custom validity
        document.getElementById('confirmPassword').setCustomValidity('');
        
        // Check if passwords match
        if (newPassword !== confirmPassword) {
            document.getElementById('confirmPassword').setCustomValidity('Passwords do not match');
        }
        
        if (passwordForm.checkValidity()) {
            // Show loading state
            const submitBtn = passwordForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Updating...';
            
            // Prepare form data
            const formData = new FormData();
            formData.append('current_password', currentPassword);
            formData.append('new_password', newPassword);
            formData.append('new_password_confirmation', confirmPassword);
            formData.append('_token', '{{ csrf_token() }}');
            
            // Send AJAX request
            fetch('{{ route("dashboard.profile.update-password") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => Promise.reject(data));
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showSuccessMessage(data.message);
                    passwordForm.reset();
                    passwordForm.classList.remove('was-validated');
                } else {
                    showErrorMessage(data.message || 'An error occurred while updating password.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.message) {
                    showErrorMessage(error.message);
                } else if (error.errors) {
                    // Handle validation errors
                    const firstError = Object.values(error.errors)[0][0];
                    showErrorMessage(firstError);
                } else {
                    showErrorMessage('An error occurred while updating password.');
                }
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        } else {
            passwordForm.classList.add('was-validated');
        }
    });

    // Real-time password confirmation validation
    document.getElementById('confirmPassword').addEventListener('input', function() {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = this.value;
        
        if (newPassword !== confirmPassword) {
            this.setCustomValidity('Passwords do not match');
        } else {
            this.setCustomValidity('');
        }
    });

    // ========== REAL-TIME VALIDATION FOR PROFILE FORM ==========
    // Real-time name validation
    document.getElementById('editName').addEventListener('input', function() {
        const name = this.value.trim();
        if (name.length < 2) {
            this.setCustomValidity('Name must be at least 2 characters long');
        } else if (name.length > 255) {
            this.setCustomValidity('Name must not exceed 255 characters');
        } else {
            this.setCustomValidity('');
        }
    });

    // Real-time email validation
    document.getElementById('editEmail').addEventListener('input', function() {
        const email = this.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            this.setCustomValidity('Please enter a valid email address');
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>
@endsection