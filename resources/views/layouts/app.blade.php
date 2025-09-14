<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MediTrack Dashboard')</title>
    
    <!-- Bootstrap CSS (Local) -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom common CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('partials.sidebar')
        
        <!-- Main Content -->
        <div class="main-content flex-fill">
            <!-- Top Navigation -->
            @include('partials.navbar')
            
            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <!-- jQuery  -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    <!-- Bootstrap JS (Local) -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Custom JS -->
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- HTML to PDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Global Dashboard Functions -->
    <script>
        // Global function to show prescription receipt (used across multiple dashboard pages)
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
            <img class="logo-img" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAcMAAAHDCAYAAABYhnHeAAAACXBIWXMAAAsTAAALEwEAmpwYAACceUlEQVR4nO29abhsyVUduPLe9+qVJoTEpHkABJqQmSVA0DLYNAhQA24ZLPCAwRi78QR8Btw0YGwwxmZoZAvbmKEt2huisGxAGJvBiKEBMRiEACGBJITEUJqHUlW9e2/2j8hNrly5dsTJ+6rePe+dvb4vv8w8MZ44EbH23rEjzmq9XqNQKBQKhSXj6KIrUCgUCoXCRaPIsFAoFAqLR5FhoVAoFBaPIsNCoVAoLB5FhoVCoVBYPIoMC4VCobB4FBkWCoVCYfEoMiwUCoXC4lFkWCgUCoXFo8iwUCgUCotHkWGhUCgUFo8iw0KhUCgsHkWGhUKhUFg8igwLhUKhsHgUGRYKhUJh8SgyLBQKhcLiUWRYKBQKhcWjyLBQKBQKi0eRYaFQKBQWjyLDQqFQKCweRYaFQqFQWDyKDAuFQqGweBQZFgqFQmHxKDIsFAqFwuJRZFgoFAqFxaPIsFAoFAqLR5FhoVAoFBaPIsNCoVAoLB5FhoVCoVBYPIoMC4VCobB4FBkWCoVCYfEoMiwUCoXC4lFkWCgUCoXFo8iwUCgUCotHkWGhUCgUFo8iw0KhUCgsHkWGhUKhUFg8igwLhUKhsHgUGRYKhUJh8SgyLBQKhcLiUWRYKBQKhcWjyLBQKBQKi0eRYaFQqFQKCweRYaFQqFQWDyKDAuFQqGweBQZFgqFQmHxKDIsFAqFwuJRZFgoFAqFxaPIsFAoFAqLR5FhoVAoFBaPIsNCoVAoLB5FhoVCoVBYPIoMC4VCobB4FBkWCoVCYfEoMiwUCoXC4lFkWCgUCoXFo8iwUCgUCovHpYuuwEXjiV/xwouuQqGQYQVgfdGVKCwPv/4PP+qiq3DdUZphoTBfFBEWCtcJi9cMCzcVVgBu2Xzi/zH9BoAz+n1M/0/kf4SfogmNR5vrp1Te1c31M7SxFOlWFHaERmor+r3epIm0a1M2h0ddVhRnTd/H2BIna5OcH5cd93FK8UMwjt9nFP9Y6sL3D0p3OwqFGxRFhoUbGUcAPgzA3wDwEQAeji1hBHkxAcREv6b0OsGvsEsonD7IhS0qa+ybM4/kOpNS5H9m4q0lPbBLcmfYrZ+7FnE5rZaFJJ6S9krSZPmfbH6f0vg3AtwH4JgBvhG/jQmF2KDNp4UbECsBHAriNfk8B8GhsyS7T5Jj0Mk2P0zM5ZppfRqBZ+U5TzMp3mmB2P65c1fiy8rX92dw7ZctLoXDdUZ1xsKNiBeA5AF4I4IHY9pXQ9s6w7T+s4YV2FNdD2zvGto+dUvgJhZ1QeKQ/pvDI55jCo5xLFC/ArlB4lHOL5MPvljindMcXj9JepPC4j6hXhR/Q/2nNF+QK7UnVojMfY1WR0gnUTbm8S62kSmcZ3ZML5HlzejnAjDk/MKhDF9zsA/CoaCb7Z1DdDlB/t+QQAv4H2ot4j5EfL9doL2D8GL6CCSIaedgQT1nMCydJOCWOBxx0ucIom4H6dpOvhFI1c7sLuuOTxweP6SP7H+D/C7jwR/3mO4fmCv69gf3yvKM0t2B3z0Qf/EYDXoWmO0Q4FFBkWCj1E//gqNC3jq9Am80toJHgZWzLkF9auNv+PJRybOBwW19i8diThTmNkJ5Q1pefyQeEsfUb+XCbX/0zCQks9Qr3CqVAoLBxFhoVCYfEoMiwUCoXD4v8P2U7Hw0XxQ3UAAAAASUVORK5CYII=" alt="MediTrack Logo" />
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
    </script>
    
    @yield('scripts')
</body>
</html>
