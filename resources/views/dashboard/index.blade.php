@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Welcome Jamal Admin!')

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
                            <div class="card-value">Rs 0</div>
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
                            <div class="card-value">170</div>
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
                            <div class="card-value">0</div>
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
                            <div class="card-value">9</div>
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
                            <tr>
                                <td>amet</td>
                                <td>10</td>
                                <td>Rs 100.00</td>
                                <td>21 Feb, 2022</td>
                            </tr>
                            <tr>
                                <td>amet</td>
                                <td>10</td>
                                <td>Rs 100.00</td>
                                <td>21 Feb, 2022</td>
                            </tr>
                            <tr>
                                <td>rem</td>
                                <td>10</td>
                                <td>Rs 1400.00</td>
                                <td>21 Feb, 2022</td>
                            </tr>
                            <tr>
                                <td>repudiandae</td>
                                <td>50</td>
                                <td>Rs 9750.00</td>
                                <td>21 Feb, 2022</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">Showing 1 to 10 of 25 entries</small>
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
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
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
