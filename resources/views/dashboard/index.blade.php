@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Welcome Jamal Admin!')

@section('styles')
<style>
.dashboard-card {
    border: none;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.dashboard-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.dashboard-card .card-body {
    padding: 1.5rem;
}

.dashboard-card .card-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.dashboard-card .card-icon i {
    font-size: 1.5rem;
    color: white;
}

.dashboard-card .card-title {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.dashboard-card .card-value {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0;
}

/* Card variations */
.dashboard-card.card-cyan {
    border-left: 4px solid var(--card-cyan);
}

.dashboard-card.card-cyan .card-icon {
    background-color: var(--card-cyan);
}

.dashboard-card.card-green {
    border-left: 4px solid var(--card-green);
}

.dashboard-card.card-green .card-icon {
    background-color: var(--card-green);
}

.dashboard-card.card-red {
    border-left: 4px solid var(--card-red);
}

.dashboard-card.card-red .card-icon {
    background-color: var(--card-red);
}

.dashboard-card.card-yellow {
    border-left: 4px solid var(--card-yellow);
}

.dashboard-card.card-yellow .card-icon {
    background-color: var(--card-yellow);
}

</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Total Drugs -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-cyan">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon">
                            <i class="fas fa-pills"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="card-title">Total Drugs</div>
                            <div class="card-value">Rs {{ number_format($stats['total_drugs'], 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Categories -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-green">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="card-title">Product Categories</div>
                            <div class="card-value">{{ $stats['product_categories'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expired Products -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-red">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="card-title">Expired Products</div>
                            <div class="card-value">{{ $stats['expired_products'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-yellow">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="card-title">System Users</div>
                            <div class="card-value">{{ $stats['system_users'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today Sales Table -->
    <div class="row">
        <div class="col-12">
            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Today Sales</h5>
                    <div class="d-flex align-items-center">
                        <label class="me-2">Show</label>
                        <select class="form-select form-select-sm me-2" style="width: auto;">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                        <label class="me-3">entries</label>
                        
                        <label class="me-2">Search:</label>
                        <input type="search" class="form-control form-control-sm" style="width: 200px;" placeholder="">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Medicine <i class="fas fa-sort text-muted"></i></th>
                                <th>Quantity <i class="fas fa-sort text-muted"></i></th>
                                <th>Total Price <i class="fas fa-sort text-muted"></i></th>
                                <th>Date <i class="fas fa-sort text-muted"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todaySales as $sale)
                            <tr>
                                <td>{{ $sale['medicine'] }}</td>
                                <td>{{ $sale['quantity'] }}</td>
                                <td>Rs {{ number_format($sale['total_price'], 2) }}</td>
                                <td>{{ $sale['date'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No sales data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">Showing {{ count($todaySales) }} entries</small>
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
<!-- add custom scripts here if needed -->
@endsection