@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Prescriptions')

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

    <!-- Custom CSS -->
<style>
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after {
        display: none !important;
    }

    .dataTables_filter {
        float: left !important;
        text-align: left !important;
        margin-left: 245px; 
        margin-bottom: 10px;
        padding: 5px;   
    }

    /* Position filter next to length menu */
    .dataTables_length {
        display: flex !important;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .table-container {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-sm);
        margin-bottom: var(--spacing-xl);
    }
    
    .action-buttons .btn {
        padding: var(--spacing-xs) var(--spacing-sm);
        font-size: var(--font-size-sm);
    }

    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 1rem;
    }
    
    .breadcrumb-item a {
        color: var(--primary);
        text-decoration: none;
    }
    
    .breadcrumb-item.active {
        color: var(--text-muted);
    }

    .table thead th {
        background-color: var(--light);
        border-bottom: 2px solid var(--border-color);
        border-top: none;
        font-weight: var(--font-weight-semibold);
        color: #495057;
        padding: 1rem 0.75rem;
        font-size: var(--font-size-sm);
    }
    
    .table tbody tr {
        border-bottom: 1px solid var(--border-color);
    }
    
    .table tbody td {
        padding: 0.75rem;
        vertical-align: middle;
        border-top: none;
        font-size: var(--font-size-sm);
        color: var(--text-dark);
    }
    
    .table tbody tr:hover {
        background-color: var(--light);
    }
</style>
</style>


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
                            <li class="breadcrumb-item active" aria-current="page">Prescriptions</li>
                        </ol>
                    </nav>
                </div>
                
            </div>
            
            <div class="table-container">
                <div class="d-flex justify-content-end mb-3">
                    <a href="#" class="btn btn-standard-primary" id="addPrescriptionBtn">
                        <i class="fas fa-plus me-2"></i>New Prescription
                    </a>
                </div>

                <!-- Prescriptions Table -->
                <div class="table-responsive">
                    <table id="prescriptionsTable" class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Student ID <i class="fas fa-sort text-muted"></i></th>
                                <th>Prescription No <i class="fas fa-sort text-muted"></i></th>
                                <th>Medicines <i class="fas fa-sort text-muted"></i></th>
                                <th>Date <i class="fas fa-sort text-muted"></i></th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($prescriptions) && count($prescriptions))
                                @foreach($prescriptions as $prescription)
                                <tr>
                                    <td>{{ $prescription->student_id }}</td>
                                    <td>{{ $prescription->prescription_number }}</td>
                                    <td>{{ $prescription->medicine_names_display }}</td>
                                    <td>{{ $prescription->created_at->format('d-M-Y H:i') }}</td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <button class="btn btn-action-cyan" data-id="{{ $prescription->id }}" onclick="showPrescriptionReceipt({{ $prescription->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-action-red" data-id="{{ $prescription->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No prescriptions found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Sale Details Modal -->
<div class="modal fade" id="saleModal" tabindex="-1" aria-labelledby="saleModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saleModalLabel">Sale Details</h5>
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
                            <!-- Sale items will be inserted here -->
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
                <button type="button" class="btn btn-primary" id="printInvoice">
                    <i class="fas fa-print me-1"></i> Print Prescription
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables (Core + Bootstrap 5 Integration) -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- HTML to PDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function () {
        // Initialize DataTable with custom DOM
        var table = $('#prescriptionsTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            columnDefs: [
                {
                    orderable: false,
                    targets: -1 // Disable sorting only for the "Actions" column
                }
            ],
            order: [[3, 'desc']], // Sort by date column (newest first)
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ prescriptions per page",
                info: "Showing _START_ to _END_ of _TOTAL_ prescriptions",
                infoEmpty: "Showing 0 to 0 of 0 prescriptions",
                infoFiltered: "(filtered from _MAX_ total prescriptions)",
                emptyTable: "No prescriptions found",
                zeroRecords: "No matching prescriptions found"
            }
        });

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
        
        // Helper function to get CSRF token for AJAX requests
        function getCSRFToken() {
            return $('meta[name="csrf-token"]').attr('content');
        }
        
        // Add addPrescriptionBtn Button Click
        $('#addPrescriptionBtn').on('click', function() {
            // Redirect to prescription form page
            window.location.href = "{{ route('dashboard.prescription.create') }}";
            return false;
        });
        
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
        
        // Delete Prescription Button Click - Using SweetAlert2
        $(document).on('click', '.btn-action-red', function(e) {
            e.preventDefault();
            const $btn = $(this);
            const prescriptionId = $btn.data('id');
            const prescriptionNo = $btn.closest('tr').find('td:eq(1)').text().trim(); // prescription number column

            Swal.fire({
                title: 'Delete Prescription',
                text: `Are you sure you want to delete prescription "${prescriptionNo}"? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Perform AJAX delete
                    $.ajax({
                        url: `/dashboard/prescription/${prescriptionId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': getCSRFToken()
                        },
                        success: function(response) {
                            // Remove row from DataTable
                            table.row($btn.closest('tr')).remove().draw();
                            Swal.close();
                            showToast(response.message || 'Prescription deleted successfully', 'success');
                        },
                        error: function(xhr, status, error) {
                            Swal.close();
                            let errorMessage = 'Failed to delete prescription';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            showToast(errorMessage, 'danger');
                            console.error('Error deleting prescription:', error);
                        }
                    });
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
            
            // Generate PDF
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

        // Generate Prescription PDF function
        function generatePrescriptionPDF(prescriptionData) {
            return new Promise((resolve, reject) => {
                try {
                    // Create HTML content for PDF
                    const pdfContent = `
                        <div style="padding: 20px; font-family: Arial, sans-serif;">
                            <h2 style="text-align: center; color: #333;">MediTrack Prescription</h2>
                            <hr>
                            <div style="margin-bottom: 20px;">
                                <p><strong>Prescription No:</strong> ${prescriptionData.prescription_number}</p>
                                <p><strong>Student ID:</strong> ${prescriptionData.student_id}</p>
                                <p><strong>Date:</strong> ${prescriptionData.date}</p>
                            </div>
                            <h4>Medicines:</h4>
                            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                                <thead>
                                    <tr style="background-color: #f5f5f5;">
                                        <th style="border: 1px solid #ddd; padding: 8px;">#</th>
                                        <th style="border: 1px solid #ddd; padding: 8px;">Medicine</th>
                                        <th style="border: 1px solid #ddd; padding: 8px;">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${prescriptionData.items.map((item, index) => `
                                        <tr>
                                            <td style="border: 1px solid #ddd; padding: 8px;">${index + 1}</td>
                                            <td style="border: 1px solid #ddd; padding: 8px;">${item.medicine || 'N/A'}</td>
                                            <td style="border: 1px solid #ddd; padding: 8px;">${item.quantity}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                            <p><strong>Total Quantity:</strong> ${prescriptionData.total_quantity}</p>
                            ${prescriptionData.notes ? `<p><strong>Notes:</strong> ${prescriptionData.notes}</p>` : ''}
                            <div style="margin-top: 40px; text-align: center; color: #666;">
                                <small>Generated on ${new Date().toLocaleString()}</small>
                            </div>
                        </div>
                    `;

                    // PDF generation options
                    const options = {
                        margin: 1,
                        filename: `prescription_${prescriptionData.prescription_number}.pdf`,
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { scale: 2 },
                        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                    };

                    // Generate PDF
                    html2pdf().set(options).from(pdfContent).save().then(() => {
                        resolve();
                    }).catch((error) => {
                        reject(error);
                    });

                } catch (error) {
                    reject(error);
                }
            });
        }
    });
</script>
</script>
@endsection