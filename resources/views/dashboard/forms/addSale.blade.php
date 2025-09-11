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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.sale') }}">Prescriptions</a></li>
                            <li class="breadcrumb-item active" aria-current="page">New Prescription</li>
                        </ol>
                    </nav>
                </div>
            </div>
            
            <form id="saleForm" action="{{ route('dashboard.sale') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-container mb-4">
                            <h5 class="mb-3">Student Information</h5>
                            <div class="customer-info">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="customerName" class="form-label">Student ID<span class="required-asterisk">*</span></label>
                                        <input type="text" class="form-control" id="customerName" name="customer_name" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-container">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Items</h5>
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
                                            <th width="60%">Medicine</th>
                                            <th width="25%">Quantity</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="noItemsRow">
                                            <td colspan="3" class="text-center text-muted py-4">No items added to this prescription</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-3">
                                <label for="saleNotes" class="form-label">Notes</label>
                                <textarea class="form-control" id="saleNotes" name="notes" rows="3" placeholder="Add notes about this prescription (optional)"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="cart-summary sticky-top" style="top: 20px;">
                            <div class="cart-summary-header">
                                <h5 class="mb-0">Prescription Summary</h5>
                            </div>
                            
                            <div class="summary-row">
                                <span>Total Items:</span>
                                <span id="totalItems">0</span>
                            </div>
                            
                            <div class="summary-row">
                                <span>Total Quantity:</span>
                                <span id="totalQuantity">0</span>
                            </div>
                            
                            <div class="mt-4">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="printInvoice" name="print_prescription" checked>
                                    <label class="form-check-label" for="printInvoice">Download PDF prescription after saving</label>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100" id="saveSaleBtn">
                                    <i class="fas fa-save me-1"></i> Complete Prescription
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- HTML to PDF library -->
<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get medicines data from the controller
    const medicines = @json($medicines ?? []);
    
    // Debug: Log the medicines data from controller
    console.log('Medicines from controller:', medicines);
    console.log('Number of medicines loaded:', medicines.length);
    
    let cartItems = [];
    
    // Medicine search
    const searchInput = document.getElementById('medicineSearch');
    const searchResults = document.getElementById('searchResults');
    
    // Debug: Check if elements are found
    console.log('Search input found:', searchInput);
    console.log('Search results found:', searchResults);
    
    if (!searchInput || !searchResults) {
        console.error('Search elements not found!');
        return;
    }
    
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        console.log('Search query:', query);
        
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }
        
        // Filter medicines based on search query
        const results = medicines.filter(medicine => 
            medicine.name.toLowerCase().includes(query)
        );
        
        console.log('Search results found:', results.length);
        
        // Show search results
        if (results.length > 0) {
            searchResults.innerHTML = '';
            
            results.forEach(medicine => {
                console.log('Adding result item for:', medicine.name);
                const resultItem = document.createElement('div');
                resultItem.className = 'medicine-search-item';
                resultItem.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <span>${medicine.name}</span>
                    </div>
                    <div class="stock">In stock: ${medicine.stock}</div>
                `;
                
                resultItem.addEventListener('click', function() {
                    console.log('Clicked on:', medicine.name);
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
        console.log('Adding to cart:', medicine);
        
        // Check if item already exists in cart
        const existingItemIndex = cartItems.findIndex(item => item.id === medicine.id);
        
        if (existingItemIndex !== -1) {
            // Update existing item
            cartItems[existingItemIndex].quantity += 1;
            console.log('Updated existing item quantity');
        } else {
            // Add new item
            cartItems.push({
                id: medicine.id,
                name: medicine.name,
                quantity: 1
            });
            console.log('Added new item to cart');
        }
        
        console.log('Current cart items:', cartItems);
        
        // Update the UI
        updateCartUI();
        
        // Auto-select the quantity input for the added/updated item
        setTimeout(() => {
            const quantityInput = document.querySelector(`input[data-id="${medicine.id}"].item-quantity`);
            if (quantityInput) {
                quantityInput.focus();
                quantityInput.select();
            }
        }, 100);
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
                        <div class="input-group input-group-sm">
                            <button type="button" class="btn btn-outline-secondary decrease-qty" data-id="${item.id}">-</button>
                            <input type="number" class="form-control text-center item-quantity" value="${item.quantity}" min="1" name="items[${index}][quantity]" data-id="${item.id}">
                            <button type="button" class="btn btn-outline-secondary increase-qty" data-id="${item.id}">+</button>
                        </div>
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
        const totalItems = cartItems.length;
        const totalQuantity = cartItems.reduce((sum, item) => sum + item.quantity, 0);
        
        document.getElementById('totalItems').textContent = totalItems;
        document.getElementById('totalQuantity').textContent = totalQuantity;
        
        // Disable/enable the save button based on whether there are items
        document.getElementById('saveSaleBtn').disabled = cartItems.length === 0;
    }
    
    // Generate and download PDF
    function generatePDF() {
        return new Promise((resolve, reject) => {
            try {
                const customerName = document.getElementById('customerName').value;
                const notes = document.getElementById('saleNotes').value;
                const totalItems = cartItems.length;
                const totalQuantity = cartItems.reduce((sum, item) => sum + item.quantity, 0);
                const currentDate = new Date().toLocaleDateString();
                const currentTime = new Date().toLocaleTimeString();
                
                // Create PDF content
                const pdfContent = `
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background-color: white !important; 
            color: black !important; 
        }
        .header { 
            text-align: center; 
            border-bottom: 2px solid black; 
            padding-bottom: 20px; 
            margin-bottom: 20px; 
        }
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        .logo-img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }
        .logo { 
            font-size: 24px; 
            font-weight: bold; 
            color: #2b7ec1; 
        }
        .info-section { margin-bottom: 20px; }
        .info-row { 
            display: flex; 
            justify-content: space-between; 
            margin: 5px 0; 
            color: black !important;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0; 
        }
        th, td { 
            border: 1px solid black; 
            padding: 8px; 
            text-align: left; 
            color: black !important;
            background-color: white !important;
        }
        th { 
            background-color: white !important; 
            font-weight: bold; 
        }
        .summary { 
            margin-top: 20px; 
            padding: 15px; 
            background-color: white !important; 
            border: 1px solid black;
            color: black !important;
        }
        .footer { 
            margin-top: 30px; 
            text-align: center; 
            font-size: 12px; 
            color: black !important;
        }
        h2, h3 { color: black !important; }
        strong { color: black !important; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img class="logo-img" src="data:image/png;base64,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" alt="MediTrack Logo" />
            <div class="logo">MediTrack</div>
        </div>
        <h2>Medicine Prescription</h2>
    </div>
    
    <div class="info-section">
        <div class="info-row"><strong>Student ID:</strong> ${customerName}</div>
        <div class="info-row"><strong>Date:</strong> ${currentDate}</div>
        <div class="info-row"><strong>Time:</strong> ${currentTime}</div>
        <div class="info-row"><strong>Prescription ID:</strong> PRESC-${Date.now()}</div>
    </div>
    
    <h3>Items</h3>
    <table>
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            ${cartItems.map(item => `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                </tr>
            `).join('')}
        </tbody>
    </table>
    
    <div class="summary">
        <div class="info-row"><strong>Total Items:</strong> ${totalItems}</div>
        <div class="info-row"><strong>Total Quantity:</strong> ${totalQuantity}</div>
        ${notes ? `<div class="info-row"><strong>Notes:</strong> ${notes}</div>` : ''}
    </div>
    
    <div class="footer">
        <p>This is a computer-generated prescription</p>
        <p>MediTrack - SUSL Medical Inventory System</p>
    </div>
</body>
</html>
                `;
                
                // Create and download PDF
                const opt = {
                    margin: 0.5,
                    filename: `prescription-${Date.now()}.pdf`,
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { 
                        scale: 2,
                        backgroundColor: '#ffffff',
                        useCORS: true
                    },
                    jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                };
                
                // Use html2pdf library to generate PDF
                if (typeof html2pdf !== 'undefined') {
                    const element = document.createElement('div');
                    element.innerHTML = pdfContent;
                    
                    html2pdf().set(opt).from(element).save().then(() => {
                        console.log('PDF generated successfully');
                        resolve();
                    }).catch((error) => {
                        console.error('Error generating PDF:', error);
                        reject(error);
                    });
                } else {
                    console.warn('html2pdf library not loaded, using fallback');
                    // Fallback: open in new window for manual printing
                    const printWindow = window.open('', '_blank');
                    printWindow.document.write(pdfContent);
                    printWindow.document.close();
                    printWindow.focus();
                    setTimeout(() => {
                        printWindow.print();
                        resolve();
                    }, 1000);
                }
            } catch (error) {
                console.error('Error in generatePDF:', error);
                reject(error);
            }
        });
    }

    // Form submission
    document.getElementById('saleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (cartItems.length === 0) {
            alert('Please add at least one item to the prescription.');
            return;
        }
        
        // In a real app, you would submit the form to the server
        // For now, we'll just simulate success and generate PDF
        
        const saveButton = document.getElementById('saveSaleBtn');
        const originalText = saveButton.innerHTML;
        
        saveButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
        saveButton.disabled = true;
        
        // Simulate server processing
        setTimeout(() => {
            // Check if PDF should be generated
            const shouldPrintPrescription = document.getElementById('printInvoice').checked;
            
            if (shouldPrintPrescription) {
                console.log('Starting PDF generation...');
                generatePDF().then(() => {
                    console.log('PDF generation completed');
                    
                    // Reset form or redirect
                    saveButton.innerHTML = originalText;
                    saveButton.disabled = false;
                    
                    // Redirect to prescriptions list with success message
                    window.location.href = '{{ route("dashboard.sale") }}?success=1';
                }).catch((error) => {
                    console.error('PDF generation failed:', error);
                    // Show error message but still complete the prescription
                    alert('Prescription completed successfully! However, there was an issue generating the PDF.');
                    
                    // Reset form or redirect
                    saveButton.innerHTML = originalText;
                    saveButton.disabled = false;
                    
                    // Redirect to prescriptions list with success message
                    window.location.href = '{{ route("dashboard.sale") }}?success=1';
                });
            } else {
                // Show success message
                alert('Prescription completed successfully!');
                
                // Reset form or redirect
                saveButton.innerHTML = originalText;
                saveButton.disabled = false;
                
                // Redirect to prescriptions list with success message
                window.location.href = '{{ route("dashboard.sale") }}?success=1';
            }
        }, 1000);
    });
});
</script>
@endsection
