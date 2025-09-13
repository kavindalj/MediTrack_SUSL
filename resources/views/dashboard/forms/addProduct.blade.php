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
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('dashboard.products.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category" required onchange="toggleCustomCategory()">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3" id="custom_category_group" style="display: none;">
                            <label for="custom_category">Custom Category</label>
                            <input type="text" class="form-control" id="custom_category" name="custom_category" placeholder="Enter new category name" value="{{ old('custom_category') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" value="{{ old('quantity') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="entry_date">Entry Date</label>
                            <input type="date" class="form-control" id="entry_date" name="entry_date" value="{{ old('entry_date', date('Y-m-d')) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="expire_date">Expiry Date</label>
                            <input type="date" class="form-control" id="expire_date" name="expire_date" value="{{ old('expire_date') }}" required>
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
<script>
function toggleCustomCategory() {
    const categorySelect = document.getElementById('category');
    const customCategoryGroup = document.getElementById('custom_category_group');
    const customCategoryInput = document.getElementById('custom_category');
    
    if (categorySelect.value === 'Other') {
        customCategoryGroup.style.display = 'block';
        customCategoryInput.required = true;
    } else {
        customCategoryGroup.style.display = 'none';
        customCategoryInput.required = false;
        customCategoryInput.value = '';
    }
}

// Check on page load if "Other" was previously selected
document.addEventListener('DOMContentLoaded', function() {
    toggleCustomCategory();
});
</script>
@endsection
