@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Sales')

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
    
    .btn-view {
        background-color: #00bcd4;
        color: white;
        border: none;
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
    .btn-view:hover {
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
    
    .sale-status {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-weight: 500;
    }
    
    .status-completed {
        background-color: #e7f8e9;
        color: #28a745;
    }
    
    .status-pending {
        background-color: #fff4e6;
        color: #fd7e14;
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
    
    /* Sale amount highlighting */
    .sale-amount {
        font-weight: 600;
    }
    
    /* Search box styling */
    .btn-outline-secondary.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    
    #clear-search-button {
        display: none;
    }
    
    #clear-search-button.visible {
        display: block;
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
                            <li class="breadcrumb-item active" aria-current="page">Sales</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="#" class="btn btn-primary" id="addSaleBtn">
                        <i class="fas fa-plus me-2"></i> New Sale
                    </a>
                </div>
            </div>
            
            <div class="table-container">
                <!-- Hidden inputs to store pagination info for JavaScript -->
                <input type="hidden" id="current-page" value="{{ $sales->currentPage() ?? 1 }}">
                <input type="hidden" id="per-page" value="{{ $sales->perPage() ?? 10 }}">
                <input type="hidden" id="total-items" value="{{ $sales->total() ?? 0 }}">
                
                @if(request('search'))
                <div class="alert alert-info d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <i class="fas fa-search me-2"></i> Showing search results for: <strong>"{{ request('search') }}"</strong>
                    </div>
                    <a href="{{ route('dashboard.sale') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Clear Search
                    </a>
                </div>
                @endif

                <!-- Entry selector -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="entries-selector">
                        <label class="me-2">Show</label>
                        <select class="form-select form-select-sm d-inline-block w-auto me-2" id="per-page-selector">
                            <option value="10" {{ ($sales->perPage() ?? 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ ($sales->perPage() ?? 10) == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ ($sales->perPage() ?? 10) == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ ($sales->perPage() ?? 10) == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <label>entries per page</label>
                    </div>
                    
                    <div class="search-box">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" placeholder="Search sales..." id="search-input" value="{{ request('search') }}">
                            <button class="btn btn-sm btn-outline-secondary" type="button" id="search-button">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" type="button" id="clear-search-button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="15%">Invoice No</th>
                                <th scope="col" width="20%">Customer</th>
                                <th scope="col" width="15%">Amount</th>
                                
                                <th scope="col" width="15%">Date</th>
                                <th scope="col" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($sales) && count($sales))
                                @foreach($sales as $index => $sale)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $sale->invoice_no }}</td>
                                    <td>{{ $sale->customer_name }}</td>
                                    <td><span class="sale-amount">Rs. {{ number_format($sale->total_amount, 2) }}</span></td>
                                    
                                    <td>{{ $sale->created_at->format('d-M-Y-H:i') }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-action btn-view" data-id="{{ $sale->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-action btn-delete" data-id="{{ $sale->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No sales found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <p class="text-muted mb-0 fw-light">
                            @if(isset($sales) && $sales->total() > 0)
                                Showing {{ ($sales->currentPage() - 1) * $sales->perPage() + 1 }}
                                to {{ min($sales->currentPage() * $sales->perPage(), $sales->total()) }}
                                of {{ $sales->total() }} entries
                            @else
                                Showing 0 to 0 of 0 entries
                            @endif
                        </p>
                    </div>
                    <nav aria-label="Page navigation" class="pagination-container">
                        @if(isset($sales))
                            @php
                                // For custom pagination
                                $paginator = $sales;
                                $currentPage = $paginator->currentPage();
                                $lastPage = $paginator->lastPage();
                                $onEachSide = 1;
                                $startPage = max(1, $currentPage - $onEachSide);
                                $endPage = min($lastPage, $currentPage + $onEachSide);
                                $showDotsStart = ($startPage > 2);
                                $showDotsEnd = ($endPage < $lastPage - 1);
                            @endphp
                            
                            @if($paginator->hasPages())
                                <ul class="pagination" role="navigation">
                                    {{-- Previous Page Link --}}
                                    @if($paginator->onFirstPage())
                                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                            <span class="page-link" aria-hidden="true">« Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">« Previous</a>
                                        </li>
                                    @endif

                                    {{-- First Page Link --}}
                                    @if($startPage > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                                        </li>
                                        @if($showDotsStart)
                                            <li class="page-item disabled" aria-disabled="true">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                    @endif

                                    {{-- Page Links --}}
                                    @foreach(range($startPage, $endPage) as $page)
                                        @if($page == $currentPage)
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Last Page Link --}}
                                    @if($endPage < $lastPage)
                                        @if($showDotsEnd)
                                            <li class="page-item disabled" aria-disabled="true">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if($paginator->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next »</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                            <span class="page-link" aria-hidden="true">Next »</span>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        @else
                            <ul class="pagination" role="navigation">
                                <li class="page-item disabled" aria-disabled="true" aria-label="previous">
                                    <span class="page-link" aria-hidden="true">« Previous</span>
                                </li>
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">1</span>
                                </li>
                                <li class="page-item disabled" aria-disabled="true" aria-label="next">
                                    <span class="page-link" aria-hidden="true">Next »</span>
                                </li>
                            </ul>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Sale Details Modal -->
<div class="modal fade" id="saleModal" tabindex="-1" aria-labelledby="saleModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saleModalLabel">Sale Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="mb-2">Invoice Information</h6>
                        <p class="mb-1"><strong>Invoice No:</strong> <span id="invoice-no"></span></p>
                        <p class="mb-1"><strong>Date:</strong> <span id="sale-date"></span></p>
                        <p class="mb-1"><strong>Status:</strong> <span id="sale-status"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-2">Customer Information</h6>
                        <p class="mb-1"><strong>Name:</strong> <span id="customer-name"></span></p>
                        <p class="mb-1"><strong>Phone:</strong> <span id="customer-phone"></span></p>
                        <p class="mb-1"><strong>Email:</strong> <span id="customer-email"></span></p>
                    </div>
                </div>
                
                <h6 class="mt-4 mb-3">Items</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Medicine</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="sale-items">
                            <!-- Sale items will be inserted here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Subtotal:</td>
                                <td id="subtotal">Rs. 0.00</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Tax (5%):</td>
                                <td id="tax">Rs. 0.00</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total:</td>
                                <td id="total" class="fw-bold">Rs. 0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="mt-3">
                    <h6 class="mb-2">Notes</h6>
                    <p id="sale-notes" class="mb-0 text-muted fst-italic">No notes available</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="printInvoice">
                    <i class="fas fa-print me-1"></i> Print Invoice
                </button>
            </div>
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
                <p id="deleteConfirmText">Are you sure you want to delete this sale?</p>
                <p class="text-danger"><small>This action cannot be undone and will remove all associated sale records.</small></p>
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
<!-- add custom scripts here if needed -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's a search parameter in the URL and show the clear button if needed
        const urlParams = new URLSearchParams(window.location.search);
        const searchTerm = urlParams.get('search');
        if (searchTerm) {
            $('#search-input').val(searchTerm);
            $('#clear-search-button').addClass('visible');
        }
        
        // Initialize modals with proper focus handling
        const saleModalEl = document.getElementById('saleModal');
        const deleteModalEl = document.getElementById('deleteModal');
        
        // Create modal instances with proper options
        let saleModal = null;
        let deleteModal = null;
        
        if (saleModalEl) {
            // Create the modal instance
            saleModal = new bootstrap.Modal(saleModalEl, {
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
            // Helper function to get CSRF token for AJAX requests
            function getCSRFToken() {
                return $('meta[name="csrf-token"]').attr('content');
            }
            
            // Add Sale Button Click
            $('#addSaleBtn').on('click', function() {
                // Redirect to sale form page
                window.location.href = "{{ route('dashboard.sale.create') }}";
                return false;
            });
            
            // View Sale Button Click
            $(document).on('click', '.btn-view', function(e) {
                e.preventDefault();
                const saleId = $(this).data('id');
                
                // In a real app, you would fetch the sale details from the server
                // For now, we'll simulate with sample data
                
                // Add a spinner to indicate loading
                $('#saleModalLabel').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                
                // Simulate server delay
                setTimeout(() => {
                    $('#saleModalLabel').text('Sale Details');
                    
                    // Sample data - replace with AJAX call to fetch real data
                    const saleData = {
                        id: saleId,
                        invoice_no: 'INV-' + (10000 + parseInt(saleId)),
                        date: '09-Sep-2025-14:30',
                        status: Math.random() > 0.3 ? 'Completed' : 'Pending',
                        customer: {
                            name: 'John Doe',
                            phone: '+94 76 123 4567',
                            email: 'john.doe@example.com'
                        },
                        items: [
                            { id: 1, medicine: 'Paracetamol 500mg', quantity: 20, unit_price: 5.00, total: 100.00 },
                            { id: 2, medicine: 'Amoxicillin 250mg', quantity: 15, unit_price: 15.00, total: 225.00 },
                            { id: 3, medicine: 'Vitamin C 1000mg', quantity: 10, unit_price: 12.50, total: 125.00 }
                        ],
                        subtotal: 450.00,
                        tax: 22.50,
                        total: 472.50,
                        notes: 'Customer requested delivery on next visit.'
                    };
                    
                    // Populate modal with sale details
                    $('#invoice-no').text(saleData.invoice_no);
                    $('#sale-date').text(saleData.date);
                    $('#sale-status').text(saleData.status);
                    $('#sale-status').removeClass('status-completed status-pending');
                    $('#sale-status').addClass(saleData.status === 'Completed' ? 'status-completed' : 'status-pending');
                    
                    $('#customer-name').text(saleData.customer.name);
                    $('#customer-phone').text(saleData.customer.phone);
                    $('#customer-email').text(saleData.customer.email);
                    
                    // Clear and populate items table
                    $('#sale-items').empty();
                    saleData.items.forEach((item, index) => {
                        $('#sale-items').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.medicine}</td>
                                <td>${item.quantity}</td>
                                <td>Rs. ${item.unit_price.toFixed(2)}</td>
                                <td>Rs. ${item.total.toFixed(2)}</td>
                            </tr>
                        `);
                    });
                    
                    // Set totals
                    $('#subtotal').text(Rs. ${saleData.subtotal.toFixed(2)});
                    $('#tax').text(Rs. ${saleData.tax.toFixed(2)});
                    $('#total').text(Rs. ${saleData.total.toFixed(2)});
                    
                    // Set notes
                    if (saleData.notes) {
                        $('#sale-notes').text(saleData.notes);
                    }
                    
                    // Show modal
                    if (saleModal) {
                        saleModal.show();
                    }
                    
                    /* In a real application, you would use AJAX:
                    $.ajax({
                        url: '/dashboard/sales/' + saleId,
                        type: 'GET',
                        data: {
                            _token: getCSRFToken()
                        },
                        success: function(response) {
                            // Populate modal with real data
                            $('#invoice-no').text(response.invoice_no);
                            ...
                        },
                        error: function(error) {
                            console.error(error);
                            showToast('Error loading sale details', 'danger');
                        }
                    });
                    */
                }, 800);
            });
            
            // Delete Sale Button Click
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const saleId = $(this).data('id');
                const invoiceNo = $(this).closest('tr').find('td:eq(1)').text();
                
                $('#confirmDelete').data('id', saleId);
                // Update delete confirmation message with the invoice number
                $('#deleteConfirmText').text('Are you sure you want to delete sale with invoice "' + invoiceNo + '"?');
                
                if (deleteModal) {
                    deleteModal.show();
                }
            });
            
            // Confirm Delete Button Click
            $('#confirmDelete').on('click', function() {
                const saleId = $(this).data('id');
                
                // Add a spinner to indicate processing
                $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');
                $(this).prop('disabled', true);
                
                // Simulate server delay
                setTimeout(() => {
                    if (deleteModal) {
                        deleteModal.hide();
                    }
                    
                    // Remove the row from the table
                    $('button.btn-delete[data-id="' + saleId + '"]').closest('tr').fadeOut(300, function() {
                        $(this).remove();
                        updateTableInfo();
                    });
                    
                    // Reset the button
                    $(this).html('Delete');
                    $(this).prop('disabled', false);
                    
                    // Show success message
                    showToast('Sale deleted successfully', 'success');
                    
                    /* In a real application, you would use AJAX:
                    $.ajax({
                        url: '/dashboard/sales/' + saleId,
                        type: 'DELETE',
                        data: {
                            _token: getCSRFToken()
                        },
                        success: function(response) {
                            showToast('Sale deleted successfully', 'success');
                        },
                        error: function(error) {
                            console.error(error);
                            showToast('Error deleting sale', 'danger');
                        },
                        complete: function() {
                            $(this).html('Delete');
                            $(this).prop('disabled', false);
                        }
                    });
                    */
                }, 800);
            });
            
            // Print Invoice Button Click
            $('#printInvoice').on('click', function() {
                // In a real app, you would implement proper invoice printing logic
                // For now, we'll just show a message
                showToast('Invoice printing initiated', 'info');
            });
            
            // Per page selector change event
            $('#per-page-selector').on('change', function() {
                const perPage = $(this).val();
                // Redirect to the same page with new per_page parameter
                window.location.href = updateQueryStringParameter(window.location.href, 'per_page', perPage);
            });
            
            // Search button click
            $('#search-button').on('click', function() {
                const searchTerm = $('#search-input').val().trim();
                if (searchTerm) {
                    // Show the clear button before redirecting
                    $('#clear-search-button').addClass('visible');
                    window.location.href = updateQueryStringParameter(window.location.href, 'search', searchTerm);
                }
            });
            
            // Search input enter key
            $('#search-input').on('keyup', function(e) {
                if (e.key === 'Enter') {
                    const searchTerm = $(this).val().trim();
                    if (searchTerm) {
                        $('#search-button').click();
                    } else {
                        // If search field is empty and Enter is pressed, clear the search
                        $('#clear-search-button').click();
                    }
                }
            });
            
            // Clear search button click
            $('#clear-search-button').on('click', function() {
                // Clear the search input
                $('#search-input').val('');
                
                // Remove search parameter from URL and reload
                const url = removeQueryStringParameter(window.location.href, 'search');
                window.location.href = url;
            });
            
            // Helper to update URL query parameters
            function updateQueryStringParameter(uri, key, value) {
                const re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                const separator = uri.indexOf('?') !== -1 ? "&" : "?";
                
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + key + "=" + value + '$2');
                } else {
                    return uri + separator + key + "=" + value;
                }
            }
            
            // Helper to remove URL query parameters
            function removeQueryStringParameter(uri, key) {
                const re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                const separator = uri.indexOf('?') !== -1 ? "&" : "?";
                
                if (uri.match(re)) {
                    // If there are other parameters, remove the parameter and preserve the rest
                    if (uri.match(new RegExp("[?&]" + "(?!" + key + "=).*?(&|$)", "i"))) {
                        return uri.replace(re, '$1').replace(/(&|\?)$/, '');
                    } else {
                        // If this is the only parameter, remove everything including the ? or &
                        return uri.replace(new RegExp("([?&])" + key + "=.*$"), '');
                    }
                }
                return uri;
            }
            
            // Update the table info text
            function updateTableInfo() {
                const count = $('table tbody tr').length;
                // Get pagination data from hidden inputs
                const currentPage = parseInt($('#current-page').val() || 1);
                const perPage = parseInt($('#per-page').val() || 10);
                const total = parseInt($('#total-items').val() || count);
                
                const start = (currentPage - 1) * perPage + 1;
                const end = Math.min(currentPage * perPage, total);
                
                $('.text-muted.mb-0').text('Showing ' + start + ' to ' + end + ' of ' + total + ' entries');
            }
            
            // Show toast notification
            function showToast(message, type) {
                // Create toast container if it doesn't exist
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
        }
    });
</script>
@endsection