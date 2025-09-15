@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Add New User')

@section('styles')
<style>
    /* Form Container - Using project's design system */
    .form-container {
        background: var(--light);
        border-radius: var(--border-radius-lg);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        padding: var(--spacing-lg, 2rem);
        margin-bottom: var(--spacing-xl, 2rem);
        border: 1px solid var(--border-color);
    }
    
    /* Form Header */
    .form-header {
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }
    
    .form-header h3 {
        color: var(--dark);
        font-weight: var(--font-weight-semibold);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-header .form-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        border-radius: var(--border-radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }
    
    /* Alert Styling */
    .alert {
        border-radius: var(--border-radius-md);
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        font-size: var(--font-size-sm);
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left: 4px solid var(--success);
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 4px solid var(--danger);
    }
    
    .alert ul {
        margin: 0;
        padding-left: 1rem;
    }
    
    /* Form Groups */
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    /* Form Labels */
    .form-label {
        font-weight: var(--font-weight-medium);
        color: var(--dark);
        margin-bottom: 0.5rem;
        font-size: var(--font-size-sm);
        display: block;
    }
    
    /* Required Asterisk */
    .required-asterisk {
        color: var(--danger);
        font-weight: var(--font-weight-bold);
        margin-left: 2px;
    }
    
    /* Form Controls */
    .form-control, .form-select {
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-md);
        font-size: var(--font-size-sm);
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
        background-color: white;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem var(--focus-shadow);
        outline: none;
    }
    
    .form-control::placeholder {
        color: var(--text-muted);
        opacity: 0.7;
    }
    
    /* Form Row Styling */
    .form-row {
        background: white;
        padding: 1.5rem;
        border-radius: var(--border-radius-md);
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-color);
    }
    
    .form-row-header {
        font-weight: var(--font-weight-semibold);
        color: var(--dark);
        margin-bottom: 1rem;
        font-size: var(--font-size-base);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-row-header i {
        color: var(--primary);
    }
    
    /* Breadcrumb - Consistent styling */
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 1rem;
        font-size: var(--font-size-sm);
    }
    
    .breadcrumb-item a {
        color: var(--primary);
        text-decoration: none;
        font-weight: var(--font-weight-medium);
    }
    
    .breadcrumb-item a:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }
    
    .breadcrumb-item.active {
        color: var(--text-muted);
        font-weight: var(--font-weight-medium);
    }
    
    /* Button Styling */
    .btn-standard-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
        padding: var(--btn-padding);
        border-radius: var(--border-radius-md);
        font-weight: var(--font-weight-semibold);
        transition: all 0.2s ease;
        border: 1px solid var(--primary);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: var(--font-size-sm);
        cursor: pointer;
        min-width: 140px;
        justify-content: center;
    }
    
    .btn-standard-primary:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(43, 126, 193, 0.3);
    }
    
    .btn-standard-primary:active,
    .btn-standard-primary:focus {
        background-color: var(--primary-active);
        border-color: var(--primary-active);
        box-shadow: 0 0 0 0.2rem var(--focus-shadow);
    }
    
    .btn-standard-primary:disabled {
        background-color: var(--text-muted);
        border-color: var(--text-muted);
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    /* Secondary Button */
    .btn-secondary-outline {
        background-color: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: var(--btn-padding);
        border-radius: var(--border-radius-md);
        font-weight: var(--font-weight-medium);
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: var(--font-size-sm);
        cursor: pointer;
        min-width: 140px;
        justify-content: center;
    }
    
    .btn-secondary-outline:hover {
        background-color: var(--light);
        border-color: var(--primary);
        color: var(--primary);
        text-decoration: none;
    }
    
    /* Form Actions */
    .form-actions {
        border-top: 2px solid var(--border-color);
        padding-top: 1.5rem;
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        align-items: center;
    }
    
    /* Input Help Text */
    .form-text {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }
    
    /* Validation Styles */
    .is-invalid {
        border-color: var(--danger) !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
    
    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.75rem;
        color: var(--danger);
    }
    
    .was-validated .form-control:invalid ~ .invalid-feedback,
    .form-control.is-invalid ~ .invalid-feedback,
    .was-validated .form-select:invalid ~ .invalid-feedback,
    .form-select.is-invalid ~ .invalid-feedback {
        display: block;
    }
    
    /* Modal Enhancements */
    .modal-content {
        border-radius: var(--border-radius-lg);
        border: none;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }
    
    .modal-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white;
        border-top-left-radius: var(--border-radius-lg);
        border-top-right-radius: var(--border-radius-lg);
        padding: 1.5rem 2rem;
        border-bottom: none;
        position: relative;
    }
    
    .modal-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ffffff30, #ffffff60, #ffffff30);
    }
    
    .modal-title {
        font-weight: var(--font-weight-semibold);
        font-size: 1.25rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .modal-title i {
        font-size: 1.5rem;
        opacity: 0.9;
    }
    
    .modal-body {
        padding: 2rem;
        font-size: var(--font-size-sm);
        background: white;
    }
    
    .modal-body p {
        color: var(--text-muted);
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }
    
    .modal-body .form-group {
        margin-bottom: 0;
    }
    
    .modal-body .form-label {
        font-weight: var(--font-weight-semibold);
        color: var(--dark);
        margin-bottom: 0.75rem;
    }
    
    .modal-body .form-control {
        padding: 0.875rem 1rem;
        font-size: var(--font-size-sm);
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius-md);
        transition: all 0.3s ease;
    }
    
    .modal-body .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem var(--focus-shadow);
        transform: translateY(-1px);
    }
    
    .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border-color);
        background: linear-gradient(135deg, var(--light) 0%, #f8f9fa 100%);
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }
    
    .modal-footer .btn {
        min-width: 120px;
        padding: 0.75rem 1.5rem;
        font-weight: var(--font-weight-semibold);
        border-radius: var(--border-radius-md);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .modal-footer .btn-secondary {
        background-color: white;
        border: 2px solid var(--border-color);
        color: var(--text-muted);
    }
    
    .modal-footer .btn-secondary:hover {
        background-color: var(--light);
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-1px);
    }
    
    .modal-footer .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        border: 2px solid var(--primary);
        color: white;
    }
    
    .modal-footer .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-active) 100%);
        border-color: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(43, 126, 193, 0.4);
    }
    
    .modal-footer .btn-primary:disabled {
        background: var(--text-muted);
        border-color: var(--text-muted);
        transform: none;
        box-shadow: none;
        cursor: not-allowed;
    }
    
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }
    
    .btn-close-white:hover {
        opacity: 1;
    }
    
    /* Success modal header */
    .bg-success {
        background: linear-gradient(135deg, var(--success) 0%, #28a745 100%) !important;
    }
    
    /* Authentication Icon Styling */
    .auth-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: white;
        border: 3px solid var(--primary);
        box-shadow: 0 4px 15px rgba(43, 126, 193, 0.3);
    }
    
    /* Modal Animation */
    .modal.fade .modal-dialog {
        transform: translate(0, -50px);
        transition: transform 0.3s ease-out;
    }
    
    .modal.show .modal-dialog {
        transform: translate(0, 0);
    }
    
    /* Security Badge */
    .security-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(43, 126, 193, 0.1);
        color: var(--primary);
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius-md);
        font-size: 0.875rem;
        font-weight: var(--font-weight-medium);
        margin-bottom: 1rem;
    }
    
    /* Shake Animation for Error Feedback */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    /* Enhanced Focus States */
    .modal-body .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem var(--focus-shadow);
        transform: translateY(-1px);
    }
    
    .modal-body .form-control.is-invalid {
        border-color: var(--danger);
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    /* Password Strength Indicator */
    .password-strength {
        margin-top: 0.5rem;
        font-size: 0.75rem;
    }
    
    .password-strength-weak {
        color: var(--danger);
    }
    
    .password-strength-medium {
        color: #ffc107;
    }
    
    .password-strength-strong {
        color: var(--success);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .form-container {
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .form-actions {
            flex-direction: column-reverse;
            gap: 0.75rem;
        }
        
        .btn-standard-primary,
        .btn-secondary-outline {
            width: 100%;
        }
        
        .form-row {
            padding: 1rem;
        }
    }
    
    /* Success Animation */
    @keyframes successPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .alert-success {
        animation: successPulse 0.6s ease-in-out;
    }
    
    /* Loading State */
    .btn-loading {
        position: relative;
        pointer-events: none;
    }
    
    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        margin: auto;
        border: 2px solid transparent;
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: button-loading-spinner 1s ease infinite;
    }
    
    @keyframes button-loading-spinner {
        from {
            transform: rotate(0turn);
        }
        to {
            transform: rotate(1turn);
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.users') }}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New User</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="form-container">
                <!-- Form Header -->
                <div class="form-header">
                    <h3>
                        <div class="form-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        Add New User
                    </h3>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Main Form -->
                <form action="{{ route('dashboard.users.add.post') }}" method="POST" id="addUserForm" class="needs-validation" novalidate>
                    @csrf
                    
                    <!-- Personal Information Section -->
                    <div class="form-row">
                        <div class="form-row-header">
                            <i class="fas fa-user"></i>
                            Personal Information
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        Full Name
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="name" 
                                           name="name" 
                                           placeholder="Enter full name" 
                                           value="{{ old('name') }}" 
                                           required 
                                           minlength="2">
                                    <div class="invalid-feedback" id="nameError">
                                        Please provide a valid name (at least 2 characters).
                                    </div>
                                    <div class="form-text">Enter the user's full name</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">
                                        Email Address
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           placeholder="Enter email address" 
                                           value="{{ old('email') }}" 
                                           required 
                                           pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                                    <div class="invalid-feedback" id="emailError">
                                        Please provide a valid email address.
                                    </div>
                                    <div class="form-text">User's login email address</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role" class="form-label">
                                        User Role
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <select class="form-select" 
                                            id="role" 
                                            name="role" 
                                            required>
                                        <option value="" selected disabled>Select Role</option>
                                        @if(isset($roles) && is_array($roles))
                                            @foreach($roles as $value => $label)
                                                <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="pharmacist" {{ old('role') == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                                            <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                        @endif
                                    </select>
                                    <div class="invalid-feedback" id="roleError">
                                        Please select a role.
                                    </div>
                                    <div class="form-text">Choose the user's access level</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Information Section -->
                    <div class="form-row">
                        <div class="form-row-header">
                            <i class="fas fa-lock"></i>
                            Security Information
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label">
                                        Password
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Enter password" 
                                           required 
                                           minlength="8">
                                    <div class="invalid-feedback" id="passwordError">
                                        Please provide a valid password (at least 8 characters).
                                    </div>
                                    <div class="form-text">Must be at least 8 characters long</div>
                                    <div class="password-strength" id="passwordStrength"></div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirmPassword" class="form-label">
                                        Confirm Password
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="confirmPassword" 
                                           name="password_confirmation" 
                                           placeholder="Confirm password" 
                                           required 
                                           minlength="8">
                                    <div class="invalid-feedback" id="confirmPasswordError">
                                        Please provide a valid password (at least 8 characters).
                                    </div>
                                    <div class="form-text">Re-enter the password</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('dashboard.users') }}" class="btn-secondary-outline">
                            <i class="fas fa-times me-1"></i>
                            Cancel
                        </a>
                        <button type="button" class="btn-standard-primary" id="validateAndOpenModal">
                            <i class="fas fa-user-plus me-1"></i>
                            Add User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Admin Authentication Modal -->
<div class="modal fade" id="adminAuthModal" tabindex="-1" aria-labelledby="adminAuthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminAuthModalLabel">
                    <i class="fas fa-shield-alt"></i>
                    Admin Authentication Required
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="auth-icon">
                    <i class="fas fa-lock"></i>
                </div>
                
                <div class="security-badge">
                    <i class="fas fa-info-circle"></i>
                    Security Verification
                </div>
                
                <p class="mb-4">
                    To add a new user to the system, please confirm your administrator password. 
                    This helps ensure only authorized personnel can create new user accounts.
                </p>
                
                <div class="form-group text-start">
                    <label for="adminPassword" class="form-label">
                        <i class="fas fa-key me-2"></i>
                        Administrator Password
                    </label>
                    <input type="password" 
                           class="form-control" 
                           id="adminPassword" 
                           placeholder="Enter your administrator password" 
                           required>
                    <div id="passwordError" class="invalid-feedback">
                        Incorrect password. Please try again.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" id="confirmAddUser">
                    <i class="fas fa-check me-1"></i>
                    Verify & Add User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle"></i>
                    User Added Successfully
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="auth-icon" style="background: linear-gradient(135deg, rgba(40, 167, 69, 0.2) 0%, rgba(40, 167, 69, 0.1) 100%); border-color: rgba(40, 167, 69, 0.3); color: var(--success);">
                    <i class="fas fa-user-check"></i>
                </div>
                
                <h6 class="mb-3" style="color: var(--dark); font-weight: var(--font-weight-semibold);">
                    New User Account Created
                </h6>
                
                <p class="mb-4" style="color: var(--text-muted);">
                    The user account has been successfully created and added to the system. 
                    The new user can now log in using their credentials.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" style="min-width: 150px;">
                    <i class="fas fa-thumbs-up me-1"></i>
                    Perfect!
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize elements
    const adminAuthModal = document.getElementById('adminAuthModal');
    const adminPasswordInput = document.getElementById('adminPassword');
    const passwordError = document.getElementById('passwordError');
    const confirmAddUserBtn = document.getElementById('confirmAddUser');
    const addUserForm = document.getElementById('addUserForm');
    const validateAndOpenModalBtn = document.getElementById('validateAndOpenModal');
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    const authModal = new bootstrap.Modal(adminAuthModal);
    
    // Initialize form functionality
    initializeForm();
    
    // Password strength checker
    const passwordInput = document.getElementById('password');
    const passwordStrength = document.getElementById('passwordStrength');
    
    passwordInput.addEventListener('input', function() {
        checkPasswordStrength(this.value);
    });
    
    function checkPasswordStrength(password) {
        let strength = 0;
        let feedback = '';
        
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        switch (strength) {
            case 0:
            case 1:
                feedback = '<span class="password-strength-weak">Very Weak</span>';
                break;
            case 2:
                feedback = '<span class="password-strength-weak">Weak</span>';
                break;
            case 3:
                feedback = '<span class="password-strength-medium">Medium</span>';
                break;
            case 4:
                feedback = '<span class="password-strength-strong">Strong</span>';
                break;
            case 5:
                feedback = '<span class="password-strength-strong">Very Strong</span>';
                break;
        }
        
        passwordStrength.innerHTML = password.length > 0 ? `Password strength: ${feedback}` : '';
    }
    
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
        [nameInput, emailInput, roleSelect, password, confirmPassword].forEach(field => {
            field.classList.remove('is-invalid');
        });
        
        // Validate name
        if (!nameInput.value.trim() || nameInput.value.trim().length < 2) {
            nameInput.classList.add('is-invalid');
            document.getElementById('nameError').textContent = 'Name must be at least 2 characters long.';
            isValid = false;
        }
        
        // Validate email
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailInput.value || !emailRegex.test(emailInput.value)) {
            emailInput.classList.add('is-invalid');
            document.getElementById('emailError').textContent = 'Please enter a valid email address.';
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
            // Scroll to first invalid field
            const firstInvalid = addUserForm.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
            return false;
        }
        
        return true;
    }
    
    function initializeForm() {
        // Real-time validation
        document.getElementById('name').addEventListener('blur', function() {
            if (this.value && this.value.trim().length < 2) {
                this.classList.add('is-invalid');
                document.getElementById('nameError').textContent = 'Name must be at least 2 characters long.';
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        document.getElementById('email').addEventListener('blur', function() {
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (this.value && !emailRegex.test(this.value)) {
                this.classList.add('is-invalid');
                document.getElementById('emailError').textContent = 'Please enter a valid email address.';
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        document.getElementById('role').addEventListener('change', function() {
            if (!this.value) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        // Password confirmation validation
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            if (this.value && password && this.value !== password) {
                this.classList.add('is-invalid');
                document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        // Remove validation errors on field change
        const inputs = addUserForm.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    }
    
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
            passwordError.textContent = 'Administrator password is required for security verification.';
            return;
        }
        
        // Show loading state
        confirmAddUserBtn.disabled = true;
        confirmAddUserBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Verifying...';
        
        // Verify password via AJAX
        fetch('{{ route("dashboard.users.verify-password") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                password: password
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Password verified, close modal and submit form
                authModal.hide();
                
                // Remove the preventDefault listener
                addUserForm.removeEventListener('submit', preventFormSubmit);
                
                // Submit the form
                addUserForm.submit();
            } else {
                // Password incorrect
                adminPasswordInput.classList.add('is-invalid');
                passwordError.textContent = data.message || 'Incorrect password. Please verify your administrator credentials.';
                passwordError.style.display = 'block';
                
                // Add shake animation to modal
                const modalContent = document.querySelector('#adminAuthModal .modal-content');
                modalContent.style.animation = 'shake 0.5s ease-in-out';
                setTimeout(() => {
                    modalContent.style.animation = '';
                }, 500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            adminPasswordInput.classList.add('is-invalid');
            passwordError.textContent = 'Connection error. Please check your internet connection and try again.';
            passwordError.style.display = 'block';
        })
        .finally(() => {
            // Reset button state
            confirmAddUserBtn.disabled = false;
            confirmAddUserBtn.innerHTML = '<i class="fas fa-check me-1"></i> Verify & Add User';
        });
    });

    function preventFormSubmit(e) {
        e.preventDefault();
    }
        
    // Form validation
    addUserForm.addEventListener('submit', preventFormSubmit);
    
    // Auto-format name (capitalize first letter of each word)
    document.getElementById('name').addEventListener('blur', function() {
        if (this.value) {
            this.value = this.value.replace(/\w\S*/g, (txt) => 
                txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
            );
        }
    });
    
    // Auto-format email (lowercase)
    document.getElementById('email').addEventListener('blur', function() {
        if (this.value) {
            this.value = this.value.toLowerCase().trim();
        }
    });
});
</script>
@endsection