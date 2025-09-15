@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Add New Product')

@section('styles')
<style>
    /* Form Container - Using project's design system */
    .form-container {
        background: white;
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
        background: var(--light);
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
    
    /* Custom Category Group */
    #custom_category_group {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        padding: 1rem;
        border-radius: var(--border-radius-md);
        border: 1px solid #ffc107;
        margin-top: 0.5rem;
    }
    
    #custom_category_group .form-label {
        color: #856404;
        font-weight: var(--font-weight-semibold);
    }
    
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
    
    /* Date Input Enhancement */
    input[type="date"] {
        position: relative;
    }
    
    input[type="date"]::-webkit-calendar-picker-indicator {
        color: var(--primary);
        cursor: pointer;
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
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.products') }}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="form-container">
                <!-- Form Header -->
                <div class="form-header">
                    <h3>
                        <div class="form-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        Add New Product
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
                <form action="{{ route('dashboard.products.store') }}" method="POST">
                    @csrf
                    
                    <!-- Product Information Section -->
                    <div class="form-row">
                        <div class="form-row-header">
                            <i class="fas fa-box"></i>
                            Product Information
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        Product Name
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="name" 
                                           name="name" 
                                           placeholder="Enter product name" 
                                           value="{{ old('name') }}" 
                                           required>
                                    <div class="form-text">Enter the full name of the product</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category" class="form-label">
                                        Category
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <select class="form-select" 
                                            id="category" 
                                            name="category" 
                                            required 
                                            onchange="toggleCustomCategory()">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other (Custom)</option>
                                    </select>
                                    <div class="form-text">Select the product category</div>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Category Section -->
                        <div id="custom_category_group" style="display: none;">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="custom_category" class="form-label">
                                        Custom Category Name
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="custom_category" 
                                           name="custom_category" 
                                           placeholder="Enter new category name" 
                                           value="{{ old('custom_category') }}">
                                    <div class="form-text">This will create a new category for future use</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Information Section -->
                    <div class="form-row">
                        <div class="form-row-header">
                            <i class="fas fa-warehouse"></i>
                            Inventory Information
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity" class="form-label">
                                        Quantity
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="quantity" 
                                           name="quantity" 
                                           placeholder="Enter quantity" 
                                           value="{{ old('quantity') }}" 
                                           min="0"
                                           required>
                                    <div class="form-text">Current stock quantity</div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="entry_date" class="form-label">
                                        Entry Date
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="entry_date" 
                                           name="entry_date" 
                                           value="{{ old('entry_date', date('Y-m-d')) }}" 
                                           required>
                                    <div class="form-text">Date when product was added to inventory</div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="expire_date" class="form-label">
                                        Expiry Date
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="expire_date" 
                                           name="expire_date" 
                                           value="{{ old('expire_date') }}" 
                                           required>
                                    <div class="form-text">Product expiration date</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('dashboard.products') }}" class="btn-secondary-outline">
                            <i class="fas fa-times me-1"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn-standard-primary">
                            <i class="fas fa-save me-1"></i>
                            Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize form functionality
    initializeForm();
    
    // Check on page load if "Other" was previously selected
    toggleCustomCategory();
    
    // Set minimum date for expiry date (should be at least today)
    const expiryDateInput = document.getElementById('expire_date');
    const today = new Date().toISOString().split('T')[0];
    expiryDateInput.setAttribute('min', today);
    
    // Validate expiry date is after entry date
    const entryDateInput = document.getElementById('entry_date');
    entryDateInput.addEventListener('change', function() {
        expiryDateInput.setAttribute('min', this.value || today);
        if (expiryDateInput.value && expiryDateInput.value < this.value) {
            expiryDateInput.value = '';
        }
    });
});

function toggleCustomCategory() {
    const categorySelect = document.getElementById('category');
    const customCategoryGroup = document.getElementById('custom_category_group');
    const customCategoryInput = document.getElementById('custom_category');
    
    if (categorySelect.value === 'Other') {
        customCategoryGroup.style.display = 'block';
        customCategoryInput.required = true;
        // Smooth scroll to custom category field
        setTimeout(() => {
            customCategoryInput.focus();
        }, 300);
    } else {
        customCategoryGroup.style.display = 'none';
        customCategoryInput.required = false;
        customCategoryInput.value = '';
    }
}

function initializeForm() {
    const form = document.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    
    form.addEventListener('submit', function(e) {
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Adding Product...';
        
        // Basic client-side validation
        const requiredFields = form.querySelectorAll('input[required], select[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Validate expiry date
        const entryDate = document.getElementById('entry_date').value;
        const expiryDate = document.getElementById('expire_date').value;
        
        if (entryDate && expiryDate && new Date(expiryDate) <= new Date(entryDate)) {
            e.preventDefault();
            alert('Expiry date must be after entry date.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            return;
        }
        
        if (!isValid) {
            e.preventDefault();
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            
            // Scroll to first invalid field
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
        }
    });
    
    // Remove validation errors on field change
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
}

// Auto-format product name (capitalize first letter of each word)
document.getElementById('name').addEventListener('blur', function() {
    this.value = this.value.replace(/\w\S*/g, (txt) => 
        txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
    );
});

// Quantity validation
document.getElementById('quantity').addEventListener('input', function() {
    if (this.value < 0) {
        this.value = 0;
    }
});
</script>
@endsection
