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
@endsection



@section('scripts')
<!-- add custom scripts here if needed -->
<script>

</script>
@endsection