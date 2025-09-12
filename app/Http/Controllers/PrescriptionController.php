<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Prescription;
use App\Models\PrescriptionItem;

class PrescriptionController extends Controller
{
    public function create()
    {
        // Create an instance of ProductController to get products
        $productController = new ProductController();
        $medicines = $productController->getProducts(); // Get products and assign to $medicines
        
        // Pass the medicines data to the view
        return view('dashboard.forms.addPrescription', [
            'medicines' => $medicines  // This matches what the JavaScript expects
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'student_id' => 'required|string|max:255',
                'notes' => 'nullable|string',
                'medicines' => 'required|array|min:1',
                'medicines.*.id' => 'required|exists:products,id',
                'medicines.*.name' => 'required|string',
                'medicines.*.quantity' => 'required|integer|min:1',
                'medicines.*.dosage' => 'nullable|string'
            ]);

            // Check stock availability for all medicines
            $medicineNames = [];
            $totalItems = 0;
            $totalQuantity = 0;
            
            foreach ($validated['medicines'] as $medicine) {
                $product = Product::find($medicine['id']);
                
                if (!$product) {
                    return response()->json([
                        'success' => false,
                        'message' => "Medicine '{$medicine['name']}' not found."
                    ], 404);
                }
                
                if (!$product->hasSufficientQuantity($medicine['quantity'])) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for '{$medicine['name']}'. Available: {$product->quantity}, Requested: {$medicine['quantity']}"
                    ], 400);
                }
                
                $medicineNames[] = $medicine['name'];
                $totalItems++;
                $totalQuantity += $medicine['quantity'];
            }

            // Create the prescription
            $prescription = Prescription::create([
                'student_id' => $validated['student_id'],
                'notes' => $validated['notes'],
                'medicine_names' => $medicineNames,
                'total_items' => $totalItems,
                'total_quantity' => $totalQuantity,
                'pdf_generated' => false
            ]);

            // Create prescription items and reduce stock
            foreach ($validated['medicines'] as $medicine) {
                $product = Product::find($medicine['id']);
                
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'product_id' => $medicine['id'],
                    'medicine_name' => $medicine['name'],
                    'quantity' => $medicine['quantity'],
                    'dosage_instructions' => $medicine['dosage'] ?? null
                ]);
                
                // Stock reduction happens automatically in PrescriptionItem::boot()
            }

            return response()->json([
                'success' => true,
                'message' => 'Prescription created successfully!',
                'prescription' => [
                    'id' => $prescription->id,
                    'prescription_number' => $prescription->prescription_number
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating prescription: ' . $e->getMessage()
            ], 500);
        }
    }
}
