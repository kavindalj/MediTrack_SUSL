@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Products')

@section('styles')
    DataTables Bootstrap 5 CSS
    <link 
        href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" 
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
@endsection

@section('content')
    <div class="table-container">

        <!-- Page header (breadcrumb + Add button) -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <!-- Optional title/breadcrumbs (can be enabled if needed) -->
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
                    <tr>
                        <td>Paracetamol</td>
                        <td>Pain Relief</td>
                        <td>Rs 120.00</td>
                        <td>50</td>
                        <td>0%</td>
                        <td>12 Dec, 2025</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info text-white me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>Amoxicillin</td>
                        <td>Antibiotic</td>
                        <td>Rs 250.00</td>
                        <td>80</td>
                        <td>5%</td>
                        <td>01 Jan, 2026</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info text-white me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>Cetirizine</td>
                        <td>Allergy</td>
                        <td>Rs 90.00</td>
                        <td>120</td>
                        <td>0%</td>
                        <td>05 May, 2026</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info text-white me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
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

    <script>
        $(document).ready(function () {
            $('#productsTable').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                columnDefs: [
                    { 
                        orderable: false, 
                        targets: -1 // Disable sorting on "Action" column
                    }
                ]
            });
        });
    </script>
@endsection
