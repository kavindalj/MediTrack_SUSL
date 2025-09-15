@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Welcome ' . explode(' ', auth()->user()->name)[0] . '!')

@section('styles')
<style>
.dashboard-card {
    border: none;
    border-radius: var(--border-radius-lg);
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
    border-radius: var(--border-radius-lg);
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
    color: var(--text-muted);
    margin-bottom: 0.5rem;
    font-weight: var(--font-weight-semibold);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.dashboard-card .card-value {
    font-size: 1.8rem;
    font-weight: var(--font-weight-bold);
    color: #2c3e50;
    margin-bottom: 0;
    line-height: 1.2;
}

/* Card variations with better colors */
.dashboard-card.card-cyan {
    border-left: 4px solid var(--card-cyan);
    background: linear-gradient(135deg, #ffffff 0%, #f8fdff 100%);
}

.dashboard-card.card-cyan .card-icon {
    background: linear-gradient(135deg, var(--card-cyan) 0%, #138496 100%);
}

.dashboard-card.card-green {
    border-left: 4px solid var(--card-green);
    background: linear-gradient(135deg, #ffffff 0%, #f8fff9 100%);
}

.dashboard-card.card-green .card-icon {
    background: linear-gradient(135deg, var(--card-green) 0%, var(--action-green-hover) 100%);
}

.dashboard-card.card-red {
    border-left: 4px solid var(--card-red);
    background: linear-gradient(135deg, #ffffff 0%, #fff8f8 100%);
}

.dashboard-card.card-red .card-icon {
    background: linear-gradient(135deg, var(--card-red) 0%, var(--action-red-hover) 100%);
}

.dashboard-card.card-yellow {
    border-left: 4px solid var(--card-yellow);
    background: linear-gradient(135deg, #ffffff 0%, #fffdf5 100%);
}

.dashboard-card.card-yellow .card-icon {
    background: linear-gradient(135deg, var(--card-yellow) 0%, #e0a800 100%);
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
                            <div class="card-value">{{ $stats['total_drugs'] ?? 0 }}</div>
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
                            <div class="card-value">{{ $stats['product_categories'] ?? 0 }}</div>
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
                            <div class="card-value">{{ $stats['expired_products'] ?? 0 }}</div>
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
                            <div class="card-value">{{ $stats['system_users'] ?? 0 }}</div>
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
                                <th width="180">Medicine Names</th>
                                <th class="text-center">Total Items</th>
                                <th class="text-center">Total Quantity</th>
                                <th class="text-center">Prescription Number</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todaySales ?? [] as $prescription)
                            <tr>
                                <td class="text-center">{{ $prescription['student_id'] ?? 'N/A' }}</td>
                                <td>{{ $prescription['medicine_names'] ?? 'No medicines' }}</td>
                                <td class="text-center">{{ $prescription['total_items'] ?? 0 }}</td>
                                <td class="text-center">{{ $prescription['total_quantity'] ?? 0 }}</td>
                                <td class="text-center">{{ $prescription['prescription_number'] ?? 'N/A' }}</td>
                                <td class="text-center">
                                        <div class="action-buttons">
                                            <button class="btn btn-action-cyan" data-id="{{ $prescription['id'] ?? '' }}" onclick="showPrescriptionReceipt({{ $prescription['id'] ?? '0' }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
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
                        <small class="text-muted">Showing {{ isset($todaySales) ? count($todaySales) : 0 }} entries</small>
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

<!-- View Prescription Details Modal -->
<div class="modal fade" id="saleModal" tabindex="-1" aria-labelledby="saleModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saleModalLabel">Prescription Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="mb-2">Prescription Information</h6>
                        <p class="mb-1"><strong>Prescription No:</strong> <span id="invoice-no"></span></p>
                        <p class="mb-1"><strong>Date:</strong> <span id="sale-date"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-2">Student Information</h6>
                        <p class="mb-1"><strong>Student ID:</strong> <span id="customer-name"></span></p>
                    </div>
                </div>
                
                <h6 class="mt-4 mb-3">Items</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Medicine</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody id="sale-items">
                            <!-- Prescription items will be inserted here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Total :</td>
                                <td id="total" class="fw-bold">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="mt-3">
                    <h6 class="mb-2">Notes</h6>
                    <p id="sale-notes" class="mb-0 text-muted fst-italic">No notes available</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-standard-primary" id="printInvoice">
                    <i class="fas fa-print me-1"></i> Print Prescription
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- add custom scripts here if needed -->
<script>
    // Initialize modals with proper focus handling
    const saleModalEl = document.getElementById('saleModal');
    
    // Create modal instances with proper options
    let saleModal = null;
    
    if (saleModalEl) {
        // Create the modal instance
        saleModal = new bootstrap.Modal(saleModalEl, {
            backdrop: true,
            keyboard: true,
            focus: true
        });
    }
    
    // jQuery code for modal interactions
    if (typeof jQuery !== 'undefined') {
        // Helper function to get CSRF token for AJAX requests
        function getCSRFToken() {
            return $('meta[name="csrf-token"]').attr('content');
        }
        
        // View Prescription Button Click
        $(document).on('click', '.btn-action-cyan', function(e) {
            e.preventDefault();
            const prescriptionId = $(this).data('id');
            
            // Validate prescription ID
            if (!prescriptionId || prescriptionId === '0' || prescriptionId === '') {
                alert('Invalid prescription ID');
                return;
            }
            
            // Add a spinner to indicate loading
            $('#saleModalLabel').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            
            // Fetch prescription details via AJAX
            $.ajax({
                url: `/dashboard/prescription/${prescriptionId}/details`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': getCSRFToken()
                },
                timeout: 10000, // 10 second timeout
                success: function(prescriptionData) {
                    $('#saleModalLabel').text('Prescription Receipt');
                    
                    // Validate response data
                    if (!prescriptionData || typeof prescriptionData !== 'object') {
                        throw new Error('Invalid response data');
                    }
                    
                    // Populate modal with prescription details
                    $('#invoice-no').text(prescriptionData.prescription_number || 'N/A');
                    $('#sale-date').text(prescriptionData.date || 'N/A');
                    
                    $('#customer-name').text(prescriptionData.student_id || 'N/A');
                    
                    // Clear and populate items table
                    $('#sale-items').empty();
                    const items = prescriptionData.items || [];
                    items.forEach((item, index) => {
                        $('#sale-items').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.medicine || 'Unknown Medicine'}</td>
                                <td>${item.quantity || 0}</td>
                            </tr>
                        `);
                    });
                    
                    // Set total items count
                    $('#total').text(`${prescriptionData.total_quantity || 0}`);
                    
                    // Set notes
                    if (prescriptionData.notes && prescriptionData.notes.trim() !== '') {
                        $('#sale-notes').text(prescriptionData.notes);
                    } else {
                        $('#sale-notes').text('No additional notes');
                    }
                    
                    // Show modal
                    if (saleModal) {
                        saleModal.show();
                    }
                },
                error: function(xhr, status, error) {
                    $('#saleModalLabel').text('Prescription Receipt');
                    console.error('Error fetching prescription details:', error);
                    
                    let errorMessage = 'Failed to load prescription details';
                    if (xhr.status === 404) {
                        errorMessage = 'Prescription not found';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Server error occurred';
                    } else if (status === 'timeout') {
                        errorMessage = 'Request timed out. Please try again.';
                    }
                    
                    alert(errorMessage);
                    showToast(errorMessage, 'danger');
                }
            });
        });
        
        // Print Prescription Button Click
        $('#printInvoice').on('click', function() {
            // Get the current prescription data from the modal
            const prescriptionNumber = $('#invoice-no').text();
            const studentId = $('#customer-name').text();
            const date = $('#sale-date').text();
            const notes = $('#sale-notes').text();
            const totalQuantity = $('#total').text();
            
            // Collect items from the modal table
            const items = [];
            $('#sale-items tr').each(function() {
                const row = $(this);
                const medicine = row.find('td:eq(1)').text();
                const quantity = row.find('td:eq(2)').text();
                
                if (medicine && quantity) {
                    items.push({
                        medicine: medicine,
                        quantity: parseInt(quantity) || 0
                    });
                }
            });
            
            // Create prescription data object
            const prescriptionData = {
                prescription_number: prescriptionNumber,
                student_id: studentId,
                date: date,
                notes: notes !== 'No additional notes' ? notes : '',
                total_quantity: parseInt(totalQuantity) || 0,
                items: items
            };
            
            // Show loading state
            const originalText = $(this).html();
            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating PDF...');
            $(this).prop('disabled', true);
            
            // Generate PDF using the global function
            generatePrescriptionPDF(prescriptionData)
                .then(() => {
                    // Reset button
                    $('#printInvoice').html(originalText);
                    $('#printInvoice').prop('disabled', false);
                    showToast('Prescription PDF generated successfully', 'success');
                })
                .catch((error) => {
                    // Reset button
                    $('#printInvoice').html(originalText);
                    $('#printInvoice').prop('disabled', false);
                    showToast('Failed to generate PDF: ' + error.message, 'danger');
                    console.error('PDF generation error:', error);
                });
        });
        
        // Show toast notification
        function showToast(message, type) {
            // Create toast container if it doesn't exist
            if (!$('#toast-container').length) {
                $('body').append('<div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;"></div>');
            }
            
            // Create toast element
            const toast = $('<div class="toast align-items-center text-white bg-' + type + ' border-0" role="alert" aria-live="assertive" aria-atomic="true"></div>');
            const toastBody = $('<div class="d-flex"><div class="toast-body">' + message + '</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>');
            toast.append(toastBody);
            
            // Add to container
            $('#toast-container').append(toast);
            
            // Initialize and show toast
            const bsToast = new bootstrap.Toast(toast[0], { delay: 3000 });
            bsToast.show();
            
            // Remove toast after it's hidden
            toast.on('hidden.bs.toast', function() {
                $(this).remove();
            });
        }
    }
</script>
@endsection