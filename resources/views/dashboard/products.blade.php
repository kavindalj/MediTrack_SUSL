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
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Discount</th>
                        <th>Expiry Date</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['category'] }}</td>
                            <td>Rs {{ number_format($product['price'], 2) }}</td>
                            <td>{{ $product['quantity'] }}</td>
                            <td>{{ $product['discount'] }}</td>
                            <td>{{ $product['expiry_date'] }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info text-white me-1">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger">
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

    @section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables (Core + Bootstrap 5 Integration) -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

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
    </script>

@endsection
