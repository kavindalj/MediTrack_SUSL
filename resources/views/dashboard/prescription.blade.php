@extends('layouts.app')

@section('title', 'MediTrack Dashboard')
@section('page-title', 'Prescriptions')

@section('styles')
<!-- add custom styles here if needed -->
<style>
    .table-container {
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .action-buttons .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    .btn-view {
        background-color: #00bcd4;
        color: white;
        border: none;
    }
    
    .btn-action {
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 4px;
        border: none;
        margin: 0 3px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-edit {
        background-color: #00bcd4;
        color: white;
    }
    .btn-edit:hover {
        background-color: #00acc1;
        color: white;
    }
    .btn-view:hover {
        background-color: #00acc1;
        color: white;
    }
    .btn-delete {
        background-color: #dc3545;
        color: white;
    }
    .btn-delete:hover {
        background-color: #c82333;
        color: white;
    }
    
    .sale-status {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-weight: 500;
    }
    
    .status-completed {
        background-color: #e7f8e9;
        color: #28a745;
    }
    
    .status-pending {
        background-color: #fff4e6;
        color: #fd7e14;
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    .pagination .page-item .page-link {
        color: #0d6efd;
        border-radius: 0.25rem;
        margin: 0 2px;
        border: 1px solid #dee2e6;
        font-size: 0.9rem;
        padding: 0.4rem 0.75rem;
        transition: all 0.2s ease;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
        font-weight: 600;
    }
    
    .pagination .page-item .page-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #0d6efd;
        z-index: 2;
    }
    
    .pagination .page-item .page-link:focus {
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
        z-index: 3;
    }
    
    /* Pagination arrows styling */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-weight: normal;
    }
    
    /* Arrow hover effects */
    .pagination .page-item:first-child .page-link:hover,
    .pagination .page-item:last-child .page-link:hover {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
        transition: all 0.2s ease;
    }
    
    /* Shadow effect on active page */
    .pagination .page-item.active .page-link {
        box-shadow: 0 2px 5px rgba(13, 110, 253, 0.2);
    }
    
    /* Responsive pagination */
    @media (max-width: 576px) {
        .pagination .page-link {
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
        }
    }
    
    /* Custom pagination container */
    .pagination-container {
        background-color: #f8f9fa;
        padding: 0.5rem;
        border-radius: 0.5rem;
    }
    
    /* Sale amount highlighting */
    .sale-amount {
        font-weight: 600;
    }
    
    /* Search box styling */
    .btn-outline-secondary.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    
    #clear-search-button {
        display: none;
    }
    
    #clear-search-button.visible {
        display: block;
    }

    .search-box {
        display: flex;
        align-items: center; 
        gap: 10px;           
    }

    .search-box label {
        margin: 0;          
        font-weight: 500;  
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
                            <li class="breadcrumb-item active" aria-current="page">Prescriptions</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="#" class="btn btn-primary" id="addPrescriptionBtn">
                        <i class="fas fa-plus me-2"></i> New Prescription
                    </a>
                </div>
            </div>
            
            <div class="table-container">
                <!-- Hidden inputs to store pagination info for JavaScript -->
                <input type="hidden" id="current-page" value="{{ $prescriptions->currentPage() ?? 1 }}">
                <input type="hidden" id="per-page" value="{{ $prescriptions->perPage() ?? 10 }}">
                <input type="hidden" id="total-items" value="{{ $prescriptions->total() ?? 0 }}">
                
                @if(request('search'))
                <div class="alert alert-info d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <i class="fas fa-search me-2"></i> Showing search results for: <strong>"{{ request('search') }}"</strong>
                    </div>
                    <a href="{{ route('dashboard.prescription') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Clear Search
                    </a>
                </div>
                @endif

                <!-- Entry selector -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="entries-selector">
                        <label class="me-2">Show</label>
                        <select class="form-select form-select-sm d-inline-block w-auto me-2" id="per-page-selector">
                            <option value="10" {{ ($prescriptions->perPage() ?? 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ ($prescriptions->perPage() ?? 10) == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ ($prescriptions->perPage() ?? 10) == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ ($prescriptions->perPage() ?? 10) == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <label>entries per page</label>
                    </div>
                    
                    <div class="search-box">
                        <label>Search:</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" id="search-input" value="{{ request('search') }}">
                            <!-- <button class="btn btn-sm btn-outline-secondary" type="button" id="search-button">
                                <i class="fas fa-search"></i>
                            </button> -->
                            <button class="btn btn-sm btn-outline-secondary" type="button" id="clear-search-button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="15%">Student ID <i class="fas fa-sort text-muted"></i></th>
                                <th scope="col" width="15%">Prescription No <i class="fas fa-sort text-muted"></i></th>
                                <th scope="col" width="25%">Medicines <i class="fas fa-sort text-muted"></i></th>
                                <th scope="col" width="15%">Date <i class="fas fa-sort text-muted"></i></th>
                                <th scope="col" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($prescriptions) && count($prescriptions))
                                @foreach($prescriptions as $index => $prescription)
                                <tr>
                                    <td>{{ ($prescriptions->currentPage() - 1) * $prescriptions->perPage() + $index + 1 }}</td>
                                    <td>{{ $prescription->student_id }}</td>
                                    <td>{{ $prescription->prescription_number }}</td>
                                    <td>{{ $prescription->medicine_names_display }}</td>
                                    <td>{{ $prescription->created_at->format('d-M-Y H:i') }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-action btn-view" data-id="{{ $prescription->id }}" onclick="showPrescriptionReceipt({{ $prescription->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-action btn-delete" data-id="{{ $prescription->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No prescriptions found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <p class="text-muted mb-0 fw-light">
                            @if(isset($prescriptions) && $prescriptions->total() > 0)
                                Showing {{ ($prescriptions->currentPage() - 1) * $prescriptions->perPage() + 1 }}
                                to {{ min($prescriptions->currentPage() * $prescriptions->perPage(), $prescriptions->total()) }}
                                of {{ $prescriptions->total() }} entries
                            @else
                                Showing 0 to 0 of 0 entries
                            @endif
                        </p>
                    </div>
                    <nav aria-label="Page navigation" class="pagination-container">
                        @if(isset($prescriptions))
                            @php
                                // For custom pagination
                                $paginator = $prescriptions;
                                $currentPage = $paginator->currentPage();
                                $lastPage = $paginator->lastPage();
                                $onEachSide = 1;
                                $startPage = max(1, $currentPage - $onEachSide);
                                $endPage = min($lastPage, $currentPage + $onEachSide);
                                $showDotsStart = ($startPage > 2);
                                $showDotsEnd = ($endPage < $lastPage - 1);
                            @endphp
                            
                            @if($paginator->hasPages())
                                <ul class="pagination" role="navigation">
                                    {{-- Previous Page Link --}}
                                    @if($paginator->onFirstPage())
                                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                            <span class="page-link" aria-hidden="true">« Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">« Previous</a>
                                        </li>
                                    @endif

                                    {{-- First Page Link --}}
                                    @if($startPage > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                                        </li>
                                        @if($showDotsStart)
                                            <li class="page-item disabled" aria-disabled="true">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                    @endif

                                    {{-- Page Links --}}
                                    @foreach(range($startPage, $endPage) as $page)
                                        @if($page == $currentPage)
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Last Page Link --}}
                                    @if($endPage < $lastPage)
                                        @if($showDotsEnd)
                                            <li class="page-item disabled" aria-disabled="true">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if($paginator->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next »</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                            <span class="page-link" aria-hidden="true">Next »</span>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        @else
                            <ul class="pagination" role="navigation">
                                <li class="page-item disabled" aria-disabled="true" aria-label="previous">
                                    <span class="page-link" aria-hidden="true">« Previous</span>
                                </li>
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">1</span>
                                </li>
                                <li class="page-item disabled" aria-disabled="true" aria-label="next">
                                    <span class="page-link" aria-hidden="true">Next »</span>
                                </li>
                            </ul>
                        @endif
                    </nav>
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
                                <td colspan="2" class="text-end fw-bold">Total Items:</td>
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
<!-- HTML to PDF library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- add custom scripts here if needed -->
<script>
    // Global function to show prescription receipt (called from onclick)
    function showPrescriptionReceipt(prescriptionId) {
        // Trigger the view button click programmatically
        $('.btn-view[data-id="' + prescriptionId + '"]').trigger('click');
    }

    // Global function to generate PDF for prescription
    function generatePrescriptionPDF(prescriptionData) {
        return new Promise((resolve, reject) => {
            try {
                console.log('Generating PDF for prescription:', prescriptionData);
                
                // Format date and time
                const currentDate = new Date().toLocaleDateString();
                const currentTime = new Date().toLocaleTimeString();
                
                // Create table rows for items
                let itemsRows = '';
                prescriptionData.items.forEach((item, index) => {
                    itemsRows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.medicine}</td>
                            <td>${item.quantity}</td>
                        </tr>
                    `;
                });
                
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
        .logo { 
            font-size: 24px; 
            font-weight: bold; 
            color: #2b7ec1; 
        }
        .logo-img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
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
            <div class="logo">MediTrack SUSL</div>
        </div>
        <h2>Medicine Prescription</h2>
    </div>
    
    <div class="info-section">
        <div class="info-row"><strong>Student ID:</strong> ${prescriptionData.student_id}</div>
        <div class="info-row"><strong>Date:</strong> ${prescriptionData.date}</div>
        <div class="info-row"><strong>Prescription ID:</strong> ${prescriptionData.prescription_number}</div>
    </div>
    
    <h3>Prescribed Medicines</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Medicine Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            ${itemsRows}
        </tbody>
    </table>
    
    <div class="summary">
        <div class="info-row"><strong>Total Items:</strong> ${prescriptionData.items.length}</div>
        <div class="info-row"><strong>Total Quantity:</strong> ${prescriptionData.total_quantity}</div>
        ${prescriptionData.notes ? `<div class="info-row"><strong>Notes:</strong> ${prescriptionData.notes}</div>` : ''}
    </div>
    
    <div class="footer">
        <p>This is a computer-generated prescription</p>
        <p>MediTrack - SUSL Medical Inventory System</p>
        <p>Generated on: ${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })} at ${new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })}</p>
    </div>
</body>
</html>
                `;
                
                // Generate filename
                const filename = `prescription_${prescriptionData.prescription_number}.pdf`;
                
                // Create and download PDF
                const opt = {
                    margin: 0.5,
                    filename: filename,
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { 
                        useCORS: true,
                        backgroundColor: '#ffffff'
                    },
                    jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                };
                
                // Use html2pdf library to generate PDF
                if (typeof html2pdf !== 'undefined') {
                    console.log('html2pdf library found, generating PDF...');
                    const element = document.createElement('div');
                    element.innerHTML = pdfContent;
                    element.style.backgroundColor = '#ffffff';
                    
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
                    if (printWindow) {
                        printWindow.document.write(pdfContent);
                        printWindow.document.close();
                        setTimeout(() => {
                            printWindow.print();
                            resolve();
                        }, 1000);
                    } else {
                        reject(new Error('Unable to open print window'));
                    }
                }
            } catch (error) {
                console.error('Error in generatePrescriptionPDF:', error);
                reject(error);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's a search parameter in the URL and show the clear button if needed
        const urlParams = new URLSearchParams(window.location.search);
        const searchTerm = urlParams.get('search');
        if (searchTerm) {
            $('#search-input').val(searchTerm);
            $('#clear-search-button').addClass('visible');
        }
        
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
            
            // Add addPrescriptionBtn Button Click
            $('#addPrescriptionBtn').on('click', function() {
                // Redirect to prescription form page
                window.location.href = "{{ route('dashboard.prescription.create') }}";
                return false;
            });
            
            // View Prescription Button Click
            $(document).on('click', '.btn-view', function(e) {
                e.preventDefault();
                const prescriptionId = $(this).data('id');
                
                // Add a spinner to indicate loading
                $('#saleModalLabel').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                
                // Fetch prescription details via AJAX
                $.ajax({
                    url: `/dashboard/prescription/${prescriptionId}/details`,
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken()
                    },
                    success: function(prescriptionData) {
                        $('#saleModalLabel').text('Prescription Receipt');
                        
                        // Populate modal with prescription details
                        $('#invoice-no').text(prescriptionData.prescription_number);
                        $('#sale-date').text(prescriptionData.date);
                        
                        $('#customer-name').text(prescriptionData.student_id);
                        
                        // Clear and populate items table
                        $('#sale-items').empty();
                        prescriptionData.items.forEach((item, index) => {
                            $('#sale-items').append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.medicine}</td>
                                    <td>${item.quantity}</td>
                                </tr>
                            `);
                        });
                        
                        // Set total items count
                        $('#total').text(`${prescriptionData.total_quantity}`);
                        
                        // Set notes
                        if (prescriptionData.notes) {
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
                        $('#saleModalLabel').text('Error');
                        showToast('Failed to load prescription details', 'error');
                        console.error('Error fetching prescription details:', error);
                    }
                });
            });
            
            // Delete Prescription Button Click - Using SweetAlert2
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const prescriptionId = $btn.data('id');
                const prescriptionNo = $btn.closest('tr').find('td:eq(2)').text().trim(); // prescription number column

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
                                // remove row
                                $btn.closest('tr').fadeOut(300, function() { $(this).remove(); updateTableInfo(); });
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
            
            // Per page selector change event
            $('#per-page-selector').on('change', function() {
                const perPage = $(this).val();
                // Redirect to the same page with new per_page parameter
                window.location.href = updateQueryStringParameter(window.location.href, 'per_page', perPage);
            });
            
            // Search button click
            $('#search-button').on('click', function() {
                const searchTerm = $('#search-input').val().trim();
                if (searchTerm) {
                    // Show the clear button before redirecting
                    $('#clear-search-button').addClass('visible');
                    window.location.href = updateQueryStringParameter(window.location.href, 'search', searchTerm);
                }
            });
            
            // Search input enter key
            $('#search-input').on('keyup', function(e) {
                if (e.key === 'Enter') {
                    const searchTerm = $(this).val().trim();
                    if (searchTerm) {
                        $('#search-button').click();
                    } else {
                        // If search field is empty and Enter is pressed, clear the search
                        $('#clear-search-button').click();
                    }
                }
            });
            
            // Clear search button click
            $('#clear-search-button').on('click', function() {
                // Clear the search input
                $('#search-input').val('');
                
                // Remove search parameter from URL and reload
                const url = removeQueryStringParameter(window.location.href, 'search');
                window.location.href = url;
            });
            
            // Helper to update URL query parameters
            function updateQueryStringParameter(uri, key, value) {
                const re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                const separator = uri.indexOf('?') !== -1 ? "&" : "?";
                
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + key + "=" + value + '$2');
                } else {
                    return uri + separator + key + "=" + value;
                }
            }
            
            // Helper to remove URL query parameters
            function removeQueryStringParameter(uri, key) {
                const re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                const separator = uri.indexOf('?') !== -1 ? "&" : "?";
                
                if (uri.match(re)) {
                    // If there are other parameters, remove the parameter and preserve the rest
                    if (uri.match(new RegExp("[?&]" + "(?!" + key + "=).*?(&|$)", "i"))) {
                        return uri.replace(re, '$1').replace(/(&|\?)$/, '');
                    } else {
                        // If this is the only parameter, remove everything including the ? or &
                        return uri.replace(new RegExp("([?&])" + key + "=.*$"), '');
                    }
                }
                return uri;
            }
            
            // Update the table info text
            function updateTableInfo() {
                const count = $('table tbody tr').length;
                // Get pagination data from hidden inputs
                const currentPage = parseInt($('#current-page').val() || 1);
                const perPage = parseInt($('#per-page').val() || 10);
                const total = parseInt($('#total-items').val() || count);
                
                const start = (currentPage - 1) * perPage + 1;
                const end = Math.min(currentPage * perPage, total);
                
                $('.text-muted.mb-0').text('Showing ' + start + ' to ' + end + ' of ' + total + ' entries');
            }
            
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
    });
</script>
@endsection