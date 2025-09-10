@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Create New Sale')

@section('styles')
<style>
    .form-container {
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .items-table {
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .product-row {
        transition: all 0.2s ease;
    }
    
    .product-row:hover {
        background-color: #f8f9fa;
    }
    
    .btn-remove {
        background-color: #ffe7e7;
        color: #dc3545;
        border: none;
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    .customer-info {
        border-left: 3px solid #0d6efd;
        padding-left: 1rem;
    }
    
    .cart-summary {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1.5rem;
    }
    
    .cart-summary-header {
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    
    .summary-total {
        font-weight: bold;
        border-top: 1px solid #dee2e6;
        padding-top: 0.5rem;
        margin-top: 0.5rem;
        font-size: 1.1rem;
    }
    
    .medicine-search-results {
        position: absolute;
        background: white;
        width: 100%;
        z-index: 100;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-height: 300px;
        overflow-y: auto;
        border-radius: 0.25rem;
        border: 1px solid #ced4da;
        display: none;
    }
    
    .medicine-search-item {
        padding: 0.5rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .medicine-search-item:hover {
        background-color: #f8f9fa;
    }
    
    .medicine-search-item .stock {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .medicine-search-item .price {
        font-weight: 600;
        color: #198754;
    }
    
    .required-asterisk {
        color: #dc3545;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.sale') }}">Sales</a></li>
                            <li class="breadcrumb-item active" aria-current="page">New Sale</li>
                        </ol>
                    </nav>
                </div>
            </div>
            
            <form id="saleForm" action="{{ route('dashboard.sale') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-container mb-4">
                            <h5 class="mb-3">Customer Information</h5>
                            <div class="customer-info">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="customerName" class="form-label">Customer Name <span class="required-asterisk">*</span></label>
                                        <input type="text" class="form-control" id="customerName" name="customer_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="customerPhone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="customerPhone" name="customer_phone">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="customerEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="customerEmail" name="customer_email">
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-container">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Items</h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addItemBtn">
                                    <i class="fas fa-plus me-1"></i> Add Item
                                </button>
                            </div>
                            
                            <div class="position-relative mb-3">
                                <label for="medicineSearch" class="form-label">Search Medicine</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="medicineSearch" placeholder="Type medicine name to search...">
                                    <button class="btn btn-outline-secondary" type="button" id="searchMedicineBtn">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="medicine-search-results" id="searchResults">
                                    <!-- Search results will appear here -->
                                </div>
                            </div>
                            
                            <div class="table-responsive items-table">
                                <table class="table" id="itemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="40%">Medicine</th>
                                            <th width="15%">Unit Price</th>
                                            <th width="15%">Quantity</th>
                                            <th width="20%">Total</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="noItemsRow">
                                            <td colspan="5" class="text-center text-muted py-4">No items added to this sale</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-3">
                                <label for="saleNotes" class="form-label">Notes</label>
                                <textarea class="form-control" id="saleNotes" name="notes" rows="3" placeholder="Add notes about this sale (optional)"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="cart-summary sticky-top" style="top: 20px;">
                            <div class="cart-summary-header">
                                <h5 class="mb-0">Sale Summary</h5>
                            </div>
                            
                            <div class="summary-row">
                                <span>Subtotal:</span>
                                <span id="subtotal">Rs. 0.00</span>
                            </div>
                            
                            <div class="summary-row">
                                <span>Tax (5%):</span>
                                <span id="tax">Rs. 0.00</span>
                            </div>
                            
                            <div class="summary-row summary-total">
                                <span>Total:</span>
                                <span id="total">Rs. 0.00</span>
                            </div>
                            
                            <input type="hidden" name="subtotal_amount" id="subtotalInput" value="0">
                            <input type="hidden" name="tax_amount" id="taxInput" value="0">
                            <input type="hidden" name="total_amount" id="totalInput" value="0">
                            
                            <div class="mt-4">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="printInvoice" name="print_invoice" checked>
                                    <label class="form-check-label" for="printInvoice">Print invoice after saving</label>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100" id="saveSaleBtn">
                                    <i class="fas fa-save me-1"></i> Complete Sale
                                </button>
                                
                                <!-- <button type="button" class="btn btn-outline-secondary w-100 mt-2" onclick="window.location.href='{{ route('dashboard.sale') }}'">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="itemName" class="form-label">Medicine <span class="required-asterisk">*</span></label>
                    <select class="form-select" id="itemName" required>
                        <option value="" selected disabled>Select medicine</option>
                        <option value="1">Paracetamol 500mg</option>
                        <option value="2">Amoxicillin 250mg</option>
                        <option value="3">Omeprazole 20mg</option>
                        <option value="4">Ibuprofen 400mg</option>
                        <option value="5">Cetirizine 10mg</option>
                        <option value="6">Vitamin C 1000mg</option>
                        <option value="7">Aspirin 75mg</option>
                        <option value="8">Metformin 500mg</option>
                        <option value="9">Atorvastatin 10mg</option>
                        <option value="10">Azithromycin 500mg</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="itemPrice" class="form-label">Unit Price (Rs) <span class="required-asterisk">*</span></label>
                    <input type="number" class="form-control" id="itemPrice" step="0.01" min="0" required>
                </div>
                
                <div class="mb-3">
                    <label for="itemQuantity" class="form-label">Quantity <span class="required-asterisk">*</span></label>
                    <input type="number" class="form-control" id="itemQuantity" min="1" value="1" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Total</label>
                    <div class="form-control bg-light" id="itemTotal">Rs. 0.00</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAddItem">Add to Sale</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize modal
    const addItemModalEl = document.getElementById('addItemModal');
    let addItemModal = null;
    
    if (addItemModalEl) {
        addItemModal = new bootstrap.Modal(addItemModalEl, {
            backdrop: true,
            keyboard: true,
            focus: true
        });
    }
    
    // Sample medicine data (in a real app, this would come from the database)
    const medicines = [
        { id: 1, name: 'Paracetamol 500mg', price: 5.00, stock: 500 },
        { id: 2, name: 'Amoxicillin 250mg', price: 15.00, stock: 300 },
        { id: 3, name: 'Omeprazole 20mg', price: 12.50, stock: 200 },
        { id: 4, name: 'Ibuprofen 400mg', price: 7.50, stock: 400 },
        { id: 5, name: 'Cetirizine 10mg', price: 6.00, stock: 350 },
        { id: 6, name: 'Vitamin C 1000mg', price: 8.00, stock: 600 },
        { id: 7, name: 'Aspirin 75mg', price: 4.50, stock: 450 },
        { id: 8, name: 'Metformin 500mg', price: 10.00, stock: 250 },
        { id: 9, name: 'Atorvastatin 10mg', price: 18.00, stock: 180 },
        { id: 10, name: 'Azithromycin 500mg', price: 25.00, stock: 150 }
    ];
    
    let cartItems = [];
    
    // Add Item button click
    document.getElementById('addItemBtn').addEventListener('click', function() {
        document.getElementById('itemName').value = '';
        document.getElementById('itemPrice').value = '';
        document.getElementById('itemQuantity').value = '1';
        document.getElementById('itemTotal').textContent = 'Rs. 0.00';
        
        if (addItemModal) {
            addItemModal.show();
        }
    });
    
    // Calculate item total when price or quantity changes
    ['itemPrice', 'itemQuantity'].forEach(id => {
        document.getElementById(id).addEventListener('input', calculateItemTotal);
    });
    
    function calculateItemTotal() {
        const price = parseFloat(document.getElementById('itemPrice').value) || 0;
        const qty = parseInt(document.getElementById('itemQuantity').value) || 0;
        const total = price * qty;
        document.getElementById('itemTotal').textContent = `Rs. ${total.toFixed(2)}`;
    }
    
    // Item selection change - update price
    document.getElementById('itemName').addEventListener('change', function() {
        const medicineId = parseInt(this.value);
        const medicine = medicines.find(m => m.id === medicineId);
        
        if (medicine) {
            document.getElementById('itemPrice').value = medicine.price.toFixed(2);
            calculateItemTotal();
        }
    });
    
    // Confirm Add Item button click
    document.getElementById('confirmAddItem').addEventListener('click', function() {
        const selectEl = document.getElementById('itemName');
        const medicineId = parseInt(selectEl.value);
        
        if (!medicineId) {
            alert('Please select a medicine');
            return;
        }
        
        const medicineName = selectEl.options[selectEl.selectedIndex].text;
        const price = parseFloat(document.getElementById('itemPrice').value);
        const quantity = parseInt(document.getElementById('itemQuantity').value);
        
        if (!price || price <= 0) {
            alert('Please enter a valid price');
            return;
        }
        
        if (!quantity || quantity <= 0) {
            alert('Please enter a valid quantity');
            return;
        }
        
        const total = price * quantity;
        
        // Add to cart items array
        const newItem = {
            id: medicineId,
            name: medicineName,
            price: price,
            quantity: quantity,
            total: total
        };
        
        // Check if item already exists in cart
        const existingItemIndex = cartItems.findIndex(item => item.id === medicineId);
        
        if (existingItemIndex !== -1) {
            // Update existing item
            cartItems[existingItemIndex].quantity += quantity;
            cartItems[existingItemIndex].total += total;
        } else {
            // Add new item
            cartItems.push(newItem);
        }
        
        // Update the UI
        updateCartUI();
        
        // Hide the modal
        if (addItemModal) {
            addItemModal.hide();
        }
    });
    
    // Medicine search
    const searchInput = document.getElementById('medicineSearch');
    const searchResults = document.getElementById('searchResults');
    
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }
        
        // Filter medicines based on search query
        const results = medicines.filter(medicine => 
            medicine.name.toLowerCase().includes(query)
        );
        
        // Show search results
        if (results.length > 0) {
            searchResults.innerHTML = '';
            
            results.forEach(medicine => {
                const resultItem = document.createElement('div');
                resultItem.className = 'medicine-search-item';
                resultItem.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <span>${medicine.name}</span>
                        <span class="price">Rs. ${medicine.price.toFixed(2)}</span>
                    </div>
                    <div class="stock">In stock: ${medicine.stock}</div>
                `;
                
                resultItem.addEventListener('click', function() {
                    addToCart(medicine);
                    searchInput.value = '';
                    searchResults.style.display = 'none';
                });
                
                searchResults.appendChild(resultItem);
            });
            
            searchResults.style.display = 'block';
        } else {
            searchResults.innerHTML = '<div class="medicine-search-item">No medicines found</div>';
            searchResults.style.display = 'block';
        }
    });
    
    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });
    
    // Add medicine from search results to cart
    function addToCart(medicine) {
        // Check if item already exists in cart
        const existingItemIndex = cartItems.findIndex(item => item.id === medicine.id);
        
        if (existingItemIndex !== -1) {
            // Update existing item
            cartItems[existingItemIndex].quantity += 1;
            cartItems[existingItemIndex].total = cartItems[existingItemIndex].price * cartItems[existingItemIndex].quantity;
        } else {
            // Add new item
            cartItems.push({
                id: medicine.id,
                name: medicine.name,
                price: medicine.price,
                quantity: 1,
                total: medicine.price
            });
        }
        
        // Update the UI
        updateCartUI();
    }
    
    // Update the cart UI
    function updateCartUI() {
        const tbody = document.querySelector('#itemsTable tbody');
        const noItemsRow = document.getElementById('noItemsRow');
        
        // Clear existing rows except the "No items" row
        const rows = tbody.querySelectorAll('tr:not(#noItemsRow)');
        rows.forEach(row => row.remove());
        
        // Show/hide "No items" row
        if (cartItems.length === 0) {
            noItemsRow.style.display = 'table-row';
        } else {
            noItemsRow.style.display = 'none';
            
            // Add items to the table
            cartItems.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = 'product-row';
                row.dataset.id = item.id;
                
                row.innerHTML = `
                    <td>
                        ${item.name}
                        <input type="hidden" name="items[${index}][medicine_id]" value="${item.id}">
                        <input type="hidden" name="items[${index}][medicine_name]" value="${item.name}">
                    </td>
                    <td>
                        Rs. ${item.price.toFixed(2)}
                        <input type="hidden" name="items[${index}][unit_price]" value="${item.price}">
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <button type="button" class="btn btn-outline-secondary decrease-qty" data-id="${item.id}">-</button>
                            <input type="number" class="form-control text-center item-quantity" value="${item.quantity}" min="1" name="items[${index}][quantity]" data-id="${item.id}">
                            <button type="button" class="btn btn-outline-secondary increase-qty" data-id="${item.id}">+</button>
                        </div>
                    </td>
                    <td>
                        Rs. ${item.total.toFixed(2)}
                        <input type="hidden" name="items[${index}][total]" value="${item.total}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-remove remove-item" data-id="${item.id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }
        
        // Update summary
        updateSummary();
        
        // Add event listeners to the new buttons
        document.querySelectorAll('.decrease-qty').forEach(button => {
            button.addEventListener('click', function() {
                updateItemQuantity(parseInt(this.dataset.id), -1);
            });
        });
        
        document.querySelectorAll('.increase-qty').forEach(button => {
            button.addEventListener('click', function() {
                updateItemQuantity(parseInt(this.dataset.id), 1);
            });
        });
        
        document.querySelectorAll('.item-quantity').forEach(input => {
            input.addEventListener('change', function() {
                const id = parseInt(this.dataset.id);
                const newQuantity = parseInt(this.value) || 1;
                if (newQuantity < 1) this.value = 1;
                updateItemQuantity(id, 0, newQuantity);
            });
        });
        
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                removeItem(parseInt(this.dataset.id));
            });
        });
    }
    
    // Update item quantity
    function updateItemQuantity(id, change, newQuantity = null) {
        const index = cartItems.findIndex(item => item.id === id);
        
        if (index !== -1) {
            if (newQuantity !== null) {
                // Set to specific quantity
                cartItems[index].quantity = newQuantity;
            } else {
                // Increment/decrement
                cartItems[index].quantity += change;
                // Ensure quantity is at least 1
                if (cartItems[index].quantity < 1) cartItems[index].quantity = 1;
            }
            
            // Update total
            cartItems[index].total = cartItems[index].price * cartItems[index].quantity;
            
            // Update UI
            updateCartUI();
        }
    }
    
    // Remove item
    function removeItem(id) {
        cartItems = cartItems.filter(item => item.id !== id);
        updateCartUI();
    }
    
    // Update summary
    function updateSummary() {
        const subtotal = cartItems.reduce((sum, item) => sum + item.total, 0);
        const taxRate = 0.05; // 5%
        const tax = subtotal * taxRate;
        const total = subtotal + tax;
        
        document.getElementById('subtotal').textContent = `Rs. ${subtotal.toFixed(2)}`;
        document.getElementById('tax').textContent = `Rs. ${tax.toFixed(2)}`;
        document.getElementById('total').textContent = `Rs. ${total.toFixed(2)}`;
        
        // Update hidden inputs for form submission
        document.getElementById('subtotalInput').value = subtotal.toFixed(2);
        document.getElementById('taxInput').value = tax.toFixed(2);
        document.getElementById('totalInput').value = total.toFixed(2);
        
        // Disable/enable the save button based on whether there are items
        document.getElementById('saveSaleBtn').disabled = cartItems.length === 0;
    }
    
    // Form submission
    document.getElementById('saleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (cartItems.length === 0) {
            alert('Please add at least one item to the sale.');
            return;
        }
        
        // In a real app, you would submit the form to the server
        // For now, we'll just simulate success and redirect
        
        const saveButton = document.getElementById('saveSaleBtn');
        const originalText = saveButton.innerHTML;
        
        saveButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
        saveButton.disabled = true;
        
        // Simulate server delay
        setTimeout(() => {
            // Redirect to sales list with success message
            window.location.href = '{{ route("dashboard.sale") }}?success=1';
        }, 1000);
    });
});
</script>
@endsection
