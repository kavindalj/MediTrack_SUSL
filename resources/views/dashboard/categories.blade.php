@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Categories')

@section('styles')
<!-- add custom styles here if needed -->
 <style>
    .table-container {
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .action-buttons .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    .btn-edit {
        background-color: #e7f8e9;
        color: #28a745;
        border: none;
    }
    
    .btn-delete {
        background-color: #ffe7e7;
        color: #dc3545;
        border: none;
    }
    
    
    .pagination {
        margin-bottom: 0;
    }
    
    .pagination .page-item .page-link {
        color: #0d6efd;
        border-radius: 0.25rem;
        margin: 0 2px;
        border: 1px solid #dee2e6;
        font-size: 0.9rem;
        padding: 0.4rem 0.75rem;
        transition: all 0.2s ease;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
        font-weight: 600;
    }
    
    .pagination .page-item .page-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #0d6efd;
        z-index: 2;
    }
    
    .pagination .page-item .page-link:focus {
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
        z-index: 3;
    }
    
    /* Pagination arrows styling */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-weight: normal;
    }
    
    /* Arrow hover effects */
    .pagination .page-item:first-child .page-link:hover,
    .pagination .page-item:last-child .page-link:hover {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
        transition: all 0.2s ease;
    }
    
    /* Shadow effect on active page */
    .pagination .page-item.active .page-link {
        box-shadow: 0 2px 5px rgba(13, 110, 253, 0.2);
    }
    
    /* Responsive pagination */
    @media (max-width: 576px) {
        .pagination .page-link {
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
        }
    }
    
    /* Custom pagination container */
    .pagination-container {
        background-color: #f8f9fa;
        padding: 0.5rem;
        border-radius: 0.5rem;
    }
</style>
@endsection

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="#" class="btn btn-primary" id="addCategoryBtn">
                        <i class="fas fa-plus me-2"></i> Add
                    </a>
                </div>
            </div>
            
            <div class="table-container">
                
                <input type="hidden" id="current-page" value="{{ $categories->currentPage() }}">
                <input type="hidden" id="per-page" value="{{ $categories->perPage() }}">
                <input type="hidden" id="total-items" value="{{ $categories->total() }}">

                <!-- Entry selector -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="entries-selector">
                        <label class="me-2">Show</label>
                        <select class="form-select form-select-sm d-inline-block w-auto me-2" id="per-page-selector">
                            <option value="10" {{ $categories->perPage() == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $categories->perPage() == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $categories->perPage() == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $categories->perPage() == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <label>entries per page</label>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="40%">Name</th>
                                <th scope="col" width="35%">Created date</th>
                                <th scope="col" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->created_at->format('d-M-Y-H:i') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-edit edit-category" data-id="{{ $category->id }}">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </button>
                                        <button class="btn btn-delete delete-category" data-id="{{ $category->id }}">
                                            <i class="fas fa-trash-alt me-1"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No categories found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <p class="text-muted mb-0 fw-light">
                            @if($categories->total() > 0)
                                Showing {{ ($categories->currentPage() - 1) * $categories->perPage() + 1 }}
                                to {{ min($categories->currentPage() * $categories->perPage(), $categories->total()) }}
                                of {{ $categories->total() }} entries
                            @else
                                Showing 0 to 0 of 0 entries
                            @endif
                        </p>
                    </div>
                    <nav aria-label="Page navigation" class="pagination-container">
                        @if ($categories->hasPages())
                            <ul class="pagination" role="navigation">
                                {{-- Previous Page Link --}}
                                @if ($categories->onFirstPage())
                                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                        <span class="page-link" aria-hidden="true">« Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $categories->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">« Previous</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @php
                                    $currentPage = $categories->currentPage();
                                    $lastPage = $categories->lastPage();
                                @endphp

                                @if ($lastPage > 1)
                                    @php
                                        // Show fixed number of links around current page
                                        $onEachSide = 1;
                                        $startPage = max(1, $currentPage - $onEachSide);
                                        $endPage = min($lastPage, $currentPage + $onEachSide);

                                        // Always show first and last page (with dots if needed)
                                        $showDotsStart = ($startPage > 2);
                                        $showDotsEnd = ($endPage < $lastPage - 1);
                                    @endphp

                                    {{-- First Page Link --}}
                                    @if ($startPage > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $categories->url(1) }}">1</a>
                                        </li>
                                        @if ($showDotsStart)
                                            <li class="page-item disabled" aria-disabled="true">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                    @endif

                                    {{-- Page Links --}}
                                    @foreach (range($startPage, $endPage) as $page)
                                        @if ($page == $currentPage)
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $categories->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Last Page Link --}}
                                    @if ($endPage < $lastPage)
                                        @if ($showDotsEnd)
                                            <li class="page-item disabled" aria-disabled="true">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $categories->url($lastPage) }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif
                                @endif

                                {{-- Next Page Link --}}
                                @if ($categories->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $categories->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next »</a>
                                    </li>
                                @else
                                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                        <span class="page-link" aria-hidden="true">Next »</span>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm">
                <div class="modal-body">
                    <input type="hidden" id="categoryId" name="category_id">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveCategory">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="deleteConfirmText">Are you sure you want to delete this category?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const categoryModalEl = document.getElementById('categoryModal');
        const deleteModalEl = document.getElementById('deleteModal');
        
        
        let categoryModal = null;
        let deleteModal = null;
        
        if (categoryModalEl) {
            
            categoryModalEl.addEventListener('shown.bs.modal', function() {
                
                document.getElementById('categoryName').focus();
            });
            
            
            categoryModal = new bootstrap.Modal(categoryModalEl, {
                backdrop: true,
                keyboard: true,
                focus: true
            });
        }
        
        if (deleteModalEl) {
            // Create the modal instance
            deleteModal = new bootstrap.Modal(deleteModalEl, {
                backdrop: true,
                keyboard: true,
                focus: true
            });
        }
        
        // jQuery code for modal interactions
        if (typeof jQuery !== 'undefined') {
            
            function getCategoryNameFromRow(categoryId) {
                const row = $('button.edit-category[data-id="' + categoryId + '"]').closest('tr');
                if (row.length) {
                    return row.find('td:eq(1)').text().trim();
                }
                return '';
            }
            
            
            function getCSRFToken() {
                return $('meta[name="csrf-token"]').attr('content');
            }
            
            
            $('#addCategoryBtn').on('click', function() {
                $('#categoryModalLabel').text('Add New Category');
                $('#categoryId').val('');
                $('#categoryName').val('');
                
                if (categoryModal) {
                    categoryModal.show();
                }
                
                
                return false;
            });
            
            // Edit Category Button Click
            $(document).on('click', '.edit-category', function(e) {
                e.preventDefault();
                const categoryId = $(this).data('id');
                const categoryName = getCategoryNameFromRow(categoryId);
                
                $('#categoryModalLabel').text('Edit Category');
                $('#categoryId').val(categoryId);
                $('#categoryName').val(categoryName);
                
                if (categoryModal) {
                    categoryModal.show();
                }
            });
            
            // Delete Category Button Click
            $(document).on('click', '.delete-category', function(e) {
                e.preventDefault();
                const categoryId = $(this).data('id');
                const categoryName = getCategoryNameFromRow(categoryId);
                
                $('#confirmDelete').data('id', categoryId);
                // Update delete confirmation message with the category name
                $('#deleteConfirmText').text('Are you sure you want to delete "' + categoryName + '"?');
                
                if (deleteModal) {
                    deleteModal.show();
                }
            });
            
            // Confirm Delete Button Click
            $('#confirmDelete').on('click', function() {
                const categoryId = $(this).data('id');
                
              
                $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');
                $(this).prop('disabled', true);
                
                // Simulate server delay
                setTimeout(() => {
                    if (deleteModal) {
                        deleteModal.hide();
                    }
                    
                    // Remove the row from the table
                    $('button.delete-category[data-id="' + categoryId + '"]').closest('tr').fadeOut(300, function() {
                        $(this).remove();
                        updateTableInfo();
                    });
                    
                    // Reset the button
                    $(this).html('Delete');
                    $(this).prop('disabled', false);
                    
                    // Show success message
                    showToast('Category deleted successfully', 'success');
                    
                    
                }, 800);
            });
            
            // Form Submit
            $('#categoryForm').on('submit', function(e) {
                e.preventDefault();
                const categoryId = $('#categoryId').val();
                const categoryName = $('#categoryName').val();
                
                if (!categoryName.trim()) {
                    showToast('Please enter a category name', 'warning');
                    return;
                }
                
                // Disable the save button and show loading spinner
                const saveBtn = $('#saveCategory');
                saveBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
                saveBtn.prop('disabled', true);
                
                // Simulate server delay
                setTimeout(() => {
                    if (categoryId) {
                        // Update existing category
                        updateCategoryInTable(categoryId, categoryName);
                        showToast('Category updated successfully', 'success');
                    } else {
                        // Add new category
                        const newId = Date.now(); // Generate a temporary ID
                        addCategoryToTable(newId, categoryName);
                        showToast('Category added successfully', 'success');
                    }
                    
                    // Close modal and reset form
                    if (categoryModal) {
                        categoryModal.hide();
                    }
                    saveBtn.html('Save');
                    saveBtn.prop('disabled', false);
                    
                   
                }, 800);
            });
            
            // Function to update a category in the table
            function updateCategoryInTable(categoryId, categoryName) {
                const row = $('button.edit-category[data-id="' + categoryId + '"]').closest('tr');
                row.find('td:eq(1)').text(categoryName);
                
                // Optional: highlight the updated row
                row.addClass('table-warning');
                setTimeout(() => {
                    row.removeClass('table-warning');
                }, 2000);
            }
            
            // Function to add a new category to the table
            function addCategoryToTable(categoryId, categoryName) {
                const tbody = $('table tbody');
                
                // Check if we had "No categories found" row
                if (tbody.find('tr td.text-center.text-muted').length) {
                    tbody.empty();
                }
                
                // Get the next index number
                const nextIndex = tbody.find('tr').length + 1;
                
                // Create new row
                const newRow = $('<tr></tr>');
                newRow.hide(); 
                
                // Add columns
                newRow.append('<td>' + nextIndex + '</td>');
                newRow.append('<td>' + categoryName + '</td>');
                newRow.append('<td>' + formatDate(new Date()) + '</td>');
                
                // Action buttons
                const actionCell = $('<td></td>');
                const actionDiv = $('<div class="action-buttons"></div>');
                
                const editBtn = $('<button class="btn btn-edit edit-category" data-id="' + categoryId + '"><i class="fas fa-edit me-1"></i> Edit</button>');
                const deleteBtn = $('<button class="btn btn-delete delete-category" data-id="' + categoryId + '"><i class="fas fa-trash-alt me-1"></i> Delete</button>');
                
                actionDiv.append(editBtn);
                actionDiv.append(' ');
                actionDiv.append(deleteBtn);
                actionCell.append(actionDiv);
                newRow.append(actionCell);
                
                // Add to table and fade in
                tbody.prepend(newRow);
                newRow.fadeIn();
                
                // Update table info
                updateTableInfo();
                
                // Optional: scroll to the new row
                $('html, body').animate({
                    scrollTop: newRow.offset().top - 150
                }, 500);
            }
            
            // Per page selector change event
            $('#per-page-selector').on('change', function() {
                const perPage = $(this).val();
                
                window.location.href = updateQueryStringParameter(window.location.href, 'per_page', perPage);
            });
            
           
            function updateQueryStringParameter(uri, key, value) {
                const re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                const separator = uri.indexOf('?') !== -1 ? "&" : "?";
                
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + key + "=" + value + '$2');
                } else {
                    return uri + separator + key + "=" + value;
                }
            }
            
            // Update the table info text
            function updateTableInfo() {
                const count = $('table tbody tr').length;
                
                const currentPage = parseInt($('#current-page').val() || 1);
                const perPage = parseInt($('#per-page').val() || 10);
                const total = parseInt($('#total-items').val() || count);
                
                const start = (currentPage - 1) * perPage + 1;
                const end = Math.min(currentPage * perPage, total);
                
                $('.text-muted.mb-0').text('Showing ' + start + ' to ' + end + ' of ' + total + ' entries');
                
                
                if (count > perPage) {
                  
                    showToast('Please refresh the page to see updated pagination', 'info');
                }
            }
            
            // Format date like "01-May-2025-12:00"
            function formatDate(date) {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                
                const day = String(date.getDate()).padStart(2, '0');
                const month = months[date.getMonth()];
                const year = date.getFullYear();
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                
                return day + '-' + month + '-' + year + '-' + hours + ':' + minutes;
            }
            
            // Show toast notification
            function showToast(message, type) {
                
                if (!$('#toast-container').length) {
                    $('body').append('<div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;"></div>');
                }
                
                // Create toast element
                const toast = $('<div class="toast align-items-center text-white bg-' + type + ' border-0" role="alert" aria-live="assertive" aria-atomic="true"></div>');
                const toastBody = $('<div class="d-flex"><div class="toast-body">' + message + '</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>');
                toast.append(toastBody);
                
                // Add to container
                $('#toast-container').append(toast);
                
                // Initialize and show toast
                const bsToast = new bootstrap.Toast(toast[0], { delay: 3000 });
                bsToast.show();
                
                // Remove toast after it's hidden
                toast.on('hidden.bs.toast', function() {
                    $(this).remove();
                });
            }
        } else {
            console.error("jQuery is not loaded! Using vanilla JS for modals instead.");
            
           
            document.getElementById('addCategoryBtn')?.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('categoryModalLabel').textContent = 'Add New Category';
                document.getElementById('categoryId').value = '';
                document.getElementById('categoryName').value = '';
                
                if (categoryModal) {
                    categoryModal.show();
                }
            });
            
         
        }
    });
</script>
@endsection