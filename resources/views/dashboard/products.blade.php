@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Products')

@section('styles')
    <!-- DataTables Bootstrap 5 CSS -->
    <link 
        href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" 
        rel="stylesheet"
    >

    <!-- Font Awesome -->
    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />

        <!-- Custom CSS -->
    <style>
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc:after {
            display: none !important;
        }

        /* Adjustable DataTables search bar position */
    .dataTables_filter {
        float: left !important;
        text-align: left !important;
        margin-left: 325px; 
        margin-bottom: 10px;
        padding: 5px;   
        }

        /* Position filter next to length menu */
        .dataTables_length {
            display: flex !important;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .expired-filter {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            font-size: 14px;
            color: #495057;
            margin: 0;
        }

        .expired-filter input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin: 0;
        }

        .expired-filter label {
            margin: 0;
            cursor: pointer;
            user-select: none;
        }

        /* Highlight expired rows */
        .expired-row {
            background-color: #ffebee !important;
            color: #c62828;
        }

        .expired-row:hover {
            background-color: #ffcdd2 !important;
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
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>

    <div class="table-container">
        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="{{ route('dashboard.products.add') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Product
            </a>
        </div>

        <!-- Products Table -->
        <div class="table-responsive">
            <table id="productsTable" class="table table-striped table-hover align-middle">
                <thead>
                     <tr>
                        <th>Product Name <i class="fas fa-sort text-muted"></i></th>
                        <th>Category <i class="fas fa-sort text-muted"></i></th>
                        <th>Quantity <i class="fas fa-sort text-muted"></i></th>
                        <th>Expire Date <i class="fas fa-sort text-muted"></i></th>
                        <th>Entry Date <i class="fas fa-sort text-muted"></i></th>
                        <th width="80">Action</th>
                        </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                        @php
                            $isExpired = $product->expire_date && $product->expire_date->isPast();
                            $isAvailable = $product->quantity > 0;
                        @endphp
                        @if($isAvailable)
                        <tr class="{{ $isExpired ? 'expired-row' : '' }}" data-expired="{{ $isExpired ? 'true' : 'false' }}">
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category }}</td>
                            <td>
                                @if($product->quantity > 0)
                                    <span class="badge bg-success">{{ $product->quantity }}</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>
                            <td>
                                @if($product->expire_date)
                                    @if($isExpired)
                                        <span class="text-danger fw-bold">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            {{ $product->expire_date->format('d M, Y') }}
                                        </span>
                                    @else
                                        {{ $product->expire_date->format('d M, Y') }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $product->entry_date ? $product->entry_date->format('d M, Y') : 'N/A' }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="deleteProduct({{ $product->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables (Core + Bootstrap 5 Integration) -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTable with custom DOM
            var table = $('#productsTable').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                columnDefs: [
                    {
                        orderable: false,
                        targets: -1 // Disable sorting only for the "Action" column
                    }
                ],
                order: [], // Default: no pre-sorting applied when table loads
                initComplete: function() {
                    // Add expired filter checkbox to the length menu area
                    var expiredFilterHtml = `
                        <div class="expired-filter">
                            <input type="checkbox" id="expiredFilter" name="expiredFilter">
                            <label for="expiredFilter">
                                <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                Show Expired Medicines 
                            </label>
                        </div>
                    `;
                    
                    $('.dataTables_length').append(expiredFilterHtml);
                }
            });

            // Expired medicines filter functionality
            $(document).on('change', '#expiredFilter', function() {
                var isChecked = this.checked;
                
                if (isChecked) {
                    // Show only expired medicines
                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            var row = table.row(dataIndex).node();
                            return $(row).data('expired') === 'true';
                        }
                    );
                } else {
                    // Show all medicines - remove the custom filter
                    $.fn.dataTable.ext.search.pop();
                }
                
                // Redraw the table to apply filter
                table.draw();
            });
        });

        function deleteProduct(productId) {
            Swal.fire({
                title: 'Delete Product',
                text: 'Are you sure you want to delete this product? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (!result.isConfirmed) return;

                // ensure CSRF header
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                Swal.fire({
                    title: 'Deleting...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: '/dashboard/products/' + productId,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: response.message || 'Product deleted successfully',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            // safe reload to reflect changes
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        let msg = 'Error deleting product';
                        if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: msg
                        });
                    }
                });
            });
        }
    </script>
@endsection
