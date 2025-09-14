@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Welcome ' . explode(' ', auth()->user()->name)[0] . '!')

@section('styles')
<style>
.dashboard-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
    height: 100%;
}

.dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.dashboard-card .card-body {
    padding: 1.8rem;
    position: relative;
}

.dashboard-card .card-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.dashboard-card .card-icon i {
    font-size: 1.4rem;
    color: white;
}

.dashboard-card .card-title {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.dashboard-card .card-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0;
    line-height: 1.2;
}

/* Card variations with better colors */
.dashboard-card.card-cyan {
    border-left: 4px solid #17a2b8;
    background: linear-gradient(135deg, #ffffff 0%, #f8fdff 100%);
}

.dashboard-card.card-cyan .card-icon {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.dashboard-card.card-green {
    border-left: 4px solid #28a745;
    background: linear-gradient(135deg, #ffffff 0%, #f8fff9 100%);
}

.dashboard-card.card-green .card-icon {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}

.dashboard-card.card-red {
    border-left: 4px solid #dc3545;
    background: linear-gradient(135deg, #ffffff 0%, #fff8f8 100%);
}

.dashboard-card.card-red .card-icon {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.dashboard-card.card-yellow {
    border-left: 4px solid #ffc107;
    background: linear-gradient(135deg, #ffffff 0%, #fffdf5 100%);
}

.dashboard-card.card-yellow .card-icon {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .dashboard-card .card-body {
        padding: 1.5rem;
    }
    
    .dashboard-card .card-value {
        font-size: 1.6rem;
    }
    
    .dashboard-card .card-icon {
        width: 45px;
        height: 45px;
    }
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
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="card-title mb-2">Total Drugs</div>
                            <div class="card-value">{{$stats['total_drugs'] }}</div>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-pills"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Categories -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-green">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="card-title mb-2">Categories</div>
                            <div class="card-value">{{ $stats['product_categories'] }}</div>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expired Products -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-red">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="card-title mb-2">Expired</div>
                            <div class="card-value">{{ $stats['expired_products'] }}</div>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-yellow">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="card-title mb-2">Users</div>
                            <div class="card-value">{{ $stats['system_users'] }}</div>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-users"></i>
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
                    <h5 class="mb-0">Today Prescription</h5>
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
                                <th class="text-center">Student ID</th>
                                <th>Medicine Names</th>
                                <th>Total Items</th>
                                <th>Total Quantity</th>
                                <th class="text-center">Prescription Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todaySales as $prescription)
                            <tr>
                                <td class="text-center">{{ $prescription['student_id'] }}</td>
                                <td>{{ $prescription['medicine_names'] }}</td>
                                <td class="text-center">{{ $prescription['total_items'] }}</td>
                                <td class="text-center">{{ $prescription['total_quantity'] }}</td>
                                <td class="text-center">{{ $prescription['prescription_number'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No prescriptions found for today</td>
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