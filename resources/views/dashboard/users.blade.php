@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Users')

@section('styles')
<style>
    .table-container {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .table {
        border: none;
        margin-bottom: 0;
    }
    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        border-top: none;
        font-weight: 600;
        color: #495057;
        padding: 15px;
        font-size: 14px;
    }
    .table tbody tr {
        border-bottom: 1px solid #e9ecef;
    }
    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-top: none;
        font-size: 14px;
        color: #333;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .btn-action {
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 4px;
        border: none;
        margin: 0 3px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-edit {
        background-color: #00bcd4;
        color: white;
    }
    .btn-edit:hover {
        background-color: #00acc1;
        color: white;
    }
    .btn-delete {
        background-color: #dc3545;
        color: white;
    }
    .btn-delete:hover {
        background-color: #c82333;
        color: white;
    }
    .role-badge {
        background-color: transparent;
        color: #333;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 500;
        text-transform: capitalize;
        border: none;
    }
    .super-admin-badge {
        background-color: transparent;
        color: #333;
        border: none;
    }
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 1rem;
    }
    .breadcrumb-item a {
        color: #0d6ffc;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #6c757d;
    }
    .add-user-btn {
        background-color: #0d6ffc;
        border-color: #0d6ffc;
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    .add-user-btn:hover {
        background-color: #1163d6;
        color: white;
        text-decoration: none;
    }
    .entries-info {
        font-size: 14px;
        color: #6c757d;
    }
    .form-select-sm, .form-control-sm {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
            
            <div class="table-container">
                <div class="d-flex justify-content-end align-items-center mb-3">
                    <a href="{{ route('dashboard.users.add') }}" class="btn add-user-btn">
                        <i class="fas fa-plus me-2"></i>Add User
                    </a>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <label class="me-2">Show</label>
                        <select class="form-select form-select-sm me-2" style="width: auto;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <label class="me-3">entries</label>
                    </div>

                    <div class="d-flex align-items-center">
                        <label class="me-2">Search:</label>
                        <input type="search" class="form-control form-control-sm" style="width: 200px;" placeholder="">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name <i class="fas fa-sort text-muted"></i></th>
                                <th>Email <i class="fas fa-sort text-muted"></i></th>
                                <th>Role <i class="fas fa-sort text-muted"></i></th>
                                <th>Created date <i class="fas fa-sort text-muted"></i></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr id="user-row-{{ $user['id'] }}">
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>
                                    <span class="role-badge {{ $user['role'] === 'super-admin' ? 'super-admin-badge' : '' }}">
                                        {{ str_replace('-', ' ', $user['role']) }}
                                    </span>
                                </td>
                                <td>{{(new DateTime($user['created_at']))->format('Y-m-d')}}</td>
                                <td>
                                    <button class="btn btn-action btn-edit" title="Edit User" onclick="editUser({{ $user['id'] }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-action btn-delete" title="Delete User" onclick="deleteUser('{{ route('dashboard.users.delete', ['id' => $user->id]) }}', '{{ $user['name'] }}', {{ $user['id'] }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No user data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="entries-info">
                        <small class="text-muted">Showing 1 to {{ count($users) }} of {{ count($users) }} entries</small>
                    </div>
                    <nav aria-label="Table pagination">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function editUser(userId) {
        Swal.fire('Edit', `Edit user functionality will be implemented for user ID: ${userId}`, 'info');
        // Later: window.location.href = `/dashboard/users/${userId}/edit`;
    }

    function deleteUser(url, userName, userId) {
        Swal.fire({
            title: `Delete user "${userName}"?`,
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (!result.isConfirmed) return;

            // Show deleting animation
            Swal.fire({
                title: 'Deleting...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    // Remove row dynamically
                    const row = document.getElementById(`user-row-${userId}`);
                    if (row) row.remove();

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: `User "${userName}" has been deleted.`,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('Failed!', 'Failed to delete user. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while deleting the user.', 'error');
            });
        });
    }

    // Search + Entries (still stubbed)
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[type="search"]');
        const entriesSelect = document.querySelector('.form-select');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                console.log('Search term:', this.value);
            });
        }

        if (entriesSelect) {
            entriesSelect.addEventListener('change', function() {
                console.log('Entries per page:', this.value);
            });
        }
    });
</script>
@endsection
