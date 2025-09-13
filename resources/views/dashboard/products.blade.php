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
@endsection

@section('content')
    <div class="table-container">

        <!-- Page header (breadcrumb + Add button) -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <!-- Optional title/breadcrumbs -->
                <!-- 
                    <h5 class="mb-1">Products</h5>
                    <small class="text-muted">Dashboard / Products</small> 
                -->
            </div>

            <!-- Add product button -->
            <a href="{{ route('dashboard.products.add') }}" class="btn btn-primary">
                Add Product
            </a>
        </div>

        <!-- Products Table -->
        <div class="table-responsive">
            <table id="productsTable" class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Expire Date</th>
                        <th>Entry Date</th>
                        <th width="80">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->expire_date ? $product->expire_date->format('d M, Y') : 'N/A' }}</td>
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
            $('#productsTable').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                columnDefs: [
                    {
                        orderable: false,
                        targets: -1 // Disable sorting only for the "Action" column
                    }
                ],
                order: [] // Default: no pre-sorting applied when table loads
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
