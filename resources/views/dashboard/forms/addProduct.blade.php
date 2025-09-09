@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Add Product')

@section('styles')
<!-- add custom styles here if needed -->
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Product</h3>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter price" step="0.01" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="manufactured_date">Manufactured Date</label>
                            <input type="date" class="form-control" id="manufactured_date" name="manufactured_date" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="expiry_date">Expiry Date</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="batch_number">Batch Number</label>
                            <input type="text" class="form-control" id="batch_number" name="batch_number" placeholder="Enter batch number" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- add custom scripts here if needed -->
@endsection
