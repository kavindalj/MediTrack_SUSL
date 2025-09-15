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
        /* Hide default DataTables sort icons */
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc:after {
            display: none !important;
        }

        /* DataTables search bar position */
        .dataTables_filter {
            float: left !important;
            text-align: left !important;
            margin-left: 321px; 
            margin-bottom: 10px;
            padding: 5px;
        }

        /* Length menu container: show entries dropdown */
        .dataTables_length {
            display: flex !important;
            align-items: center;
            justify-content: flex-start; /* Left align */
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 5px;
        }

        /* Filters container (checkboxes below length dropdown) */
        .filters-container {
            display: flex;
            gap: 10px;                /* space between checkboxes */
            margin-bottom: 10px;
            width: 100%;               /* take full width */
            white-space: nowrap;       /* prevent wrapping */
            flex-wrap: nowrap; 
        }

        /* Individual filter styling */
        .filter-item {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            font-size: 14px;
            color: #495057;
            cursor: pointer;
            user-select: none;
            transition: background 0.2s;
            flex-shrink: 0; 
        }

        /* Checkbox styling */
        .filter-item input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin: 0;
        }

        /* Hover effect for filters */
        .filter-item:hover {
            background-color: #e9ecef;
        }

        /* Expired rows */
        .expired-row {
            background-color: #ffebee !important;
            color: #c62828;
        }
        .expired-row:hover {
            background-color: #ffcdd2 !important;
        }

        /* Out of stock rows */
        .outofstock-row {
            background-color: #fff3e0 !important;
            color: #e65100;
        }
        .outofstock-row:hover {
            background-color: #ffe0b2 !important;
        }
        .add-product-btn {
            background-color: #0d6ffc;
            border-color: #0d6ffc;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        .add-product-btn:hover {
            background-color: #1163d6;
            color: white;
            text-decoration: none;
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
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>

    <div class="table-container">
        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="{{ route('dashboard.products.add') }}" class="btn add-product-btn">
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
                    @endphp
                    <tr class="{{ $isExpired ? 'expired-row' : '' }}"
                        data-expired="{{ $isExpired ? 'true' : 'false' }}"
                        data-qty="{{ (int) $product->quantity }}"
                        data-expiry="{{ $product->expire_date ? $product->expire_date->toDateString() : '' }}">
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>
                            @if($product->quantity > 0)
                                <span class="badge bg-success">{{ $product->quantity }}</span>
                            @else
                                <span class="badge bg-danger">0</span>
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
            var table = $('#productsTable').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                columnDefs: [
                    { orderable: false, targets: -1 } // Action column
                ],
                order: [],
                initComplete: function() {
                    // Create a container below the length menu with 3 checkboxes
                    var filtersHtml = `
                        <div class="filters-container">
                            <div class="filter-item">
                                <input type="checkbox" id="outOfStockFilter" name="outOfStockFilter">
                                <label for="outOfStockFilter">
                                    <i class="fas fa-box-open text-danger me-1"></i>
                                    Show Out of Stock
                                </label>
                            </div>
                            <div class="filter-item">
                                <input type="checkbox" id="expiredFilter" name="expiredFilter">
                                <label for="expiredFilter">
                                    <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                    Show Expired Medicines
                                </label>
                            </div>
                            <div class="filter-item">
                                <input type="checkbox" id="inStockFilter" name="inStockFilter">
                                <label for="inStockFilter">
                                    <i class="fas fa-check-circle text-success me-1"></i>
                                    Show In Stock
                                </label>
                            </div>
                        </div>
                    `;

                    // Append filters container below the length menu
                    $('.dataTables_length').after(filtersHtml);

                    if ($('#expiredFilter').prop('checked')) $('#expiredFilter').trigger('change');
                    if ($('#outOfStockFilter').prop('checked')) $('#outOfStockFilter').trigger('change');
                    if ($('#inStockFilter').prop('checked')) $('#inStockFilter').trigger('change');
                }



            });

            var expiredFilterFn = null;
            var outOfStockFilterFn = null;
            var inStockFilterFn = null;

            // Expired filter
            $(document).on('change', '#expiredFilter', function() {
                var isChecked = this.checked;

                if (expiredFilterFn) {
                    var idx = $.fn.dataTable.ext.search.indexOf(expiredFilterFn);
                    if (idx !== -1) $.fn.dataTable.ext.search.splice(idx, 1);
                    expiredFilterFn = null;
                }

                if (isChecked) {
                    expiredFilterFn = function(settings, data, dataIndex) {
                        var row = table.row(dataIndex).node();
                        var $row = $(row);

                        var flagExpired = ($row.data('expired') === true) || ($row.attr('data-expired') === 'true');
                        var expiryStr = $row.attr('data-expiry') || '';
                        var expiredByDate = false;
                        if (expiryStr) {
                            var expiry = new Date(expiryStr + 'T00:00:00');
                            var today = new Date();
                            today.setHours(0,0,0,0);
                            if (!isNaN(expiry)) expiredByDate = expiry.getTime() <= today.getTime();
                        }

                        var isExpired = flagExpired || expiredByDate;
                        var qty = parseFloat($row.data('qty')) || 0;

                        return isExpired;
                    };
                    $.fn.dataTable.ext.search.push(expiredFilterFn);
                }

                table.draw();
            });

            // Out of stock filter
            $(document).on('change', '#outOfStockFilter', function() {
                var isChecked = this.checked;

                if (outOfStockFilterFn) {
                    var idx = $.fn.dataTable.ext.search.indexOf(outOfStockFilterFn);
                    if (idx !== -1) $.fn.dataTable.ext.search.splice(idx, 1);
                    outOfStockFilterFn = null;
                }

                if (isChecked) {
                    outOfStockFilterFn = function(settings, data, dataIndex) {
                        var row = table.row(dataIndex).node();
                        var $row = $(row);
                        var qty = parseFloat($row.data('qty')) || 0;

                        if (qty <= 0) $($row).addClass('outofstock-row');
                        else $($row).removeClass('outofstock-row');

                        return qty <= 0;
                    };
                    $.fn.dataTable.ext.search.push(outOfStockFilterFn);
                } else {
                    // Remove highlight when unchecked
                    table.rows().every(function() {
                        $(this.node()).removeClass('outofstock-row');
                    });
                }

                table.draw();
            });

            // In Stock filter
            $(document).on('change', '#inStockFilter', function() {
                var isChecked = this.checked;

                if (inStockFilterFn) {
                    var idx = $.fn.dataTable.ext.search.indexOf(inStockFilterFn);
                    if (idx !== -1) $.fn.dataTable.ext.search.splice(idx, 1);
                    inStockFilterFn = null;
                }

                if (isChecked) {
                    inStockFilterFn = function(settings, data, dataIndex) {
                        var row = table.row(dataIndex).node();
                        var $row = $(row);
                        var qty = parseFloat($row.data('qty')) || 0;

                        return qty > 0;
                    };
                    $.fn.dataTable.ext.search.push(inStockFilterFn);
                }

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
