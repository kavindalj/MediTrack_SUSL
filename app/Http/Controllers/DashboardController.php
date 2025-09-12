<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $productController;

    public function __construct(ProductController $productController)
    {
        $this->productController = $productController;
    }
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Sample data - replace with actual database queries
        $stats = [
            'total_drugs' => 0,
            'product_categories' => 120,
            'expired_products' => 0,
            'system_users' => 9
        ];

        // Sample sales data - replace with actual database queries
        $todaySales = [
            [
                'medicine' => 'amet',
                'quantity' => 10,
                'total_price' => 100.00,
                'date' => '21 Feb, 2022'
            ],
            [
                'medicine' => 'amet',
                'quantity' => 10,
                'total_price' => 100.00,
                'date' => '21 Feb, 2022'
            ],
            [
                'medicine' => 'rem',
                'quantity' => 10,
                'total_price' => 1400.00,
                'date' => '21 Feb, 2022'
            ],
            [
                'medicine' => 'repudiandae',
                'quantity' => 50,
                'total_price' => 9750.00,
                'date' => '21 Feb, 2022'
            ]
        ];

        return view('dashboard.index', compact('stats', 'todaySales'));
    }

    public function categories()
    {
    // Create a collection of categories
    $categoriesCollection = collect([
        (object) ['id' => 1, 'name' => 'Phytopathology', 'created_at' => now()->subDays(5)],
        (object) ['id' => 2, 'name' => 'Family care', 'created_at' => now()->subDays(4)],
        (object) ['id' => 3, 'name' => 'Cancer', 'created_at' => now()->subDays(3)],
        (object) ['id' => 4, 'name' => 'Hair care', 'created_at' => now()->subDays(2)],
        (object) ['id' => 5, 'name' => 'Skin care', 'created_at' => now()->subDays(1)],
        (object) ['id' => 6, 'name' => 'Pain Relief', 'created_at' => now()->subHours(12)],
        (object) ['id' => 7, 'name' => 'Vitamins & Supplements', 'created_at' => now()->subHours(6)],
        (object) ['id' => 8, 'name' => 'Antibiotics', 'created_at' => now()->subHours(3)],
        (object) ['id' => 9, 'name' => 'Cardiology', 'created_at' => now()],
        (object) ['id' => 10, 'name' => 'Diabetes Care', 'created_at' => now()->subMinutes(30)],
        (object) ['id' => 11, 'name' => 'Respiratory', 'created_at' => now()->subMinutes(20)],
        (object) ['id' => 12, 'name' => 'Digestive Health', 'created_at' => now()->subMinutes(10)],
        (object) ['id' => 13, 'name' => 'Eye Care', 'created_at' => now()->subMinutes(5)],
        (object) ['id' => 14, 'name' => 'Oral Care', 'created_at' => now()->subMinutes(2)],
        (object) ['id' => 15, 'name' => 'Women\'s Health', 'created_at' => now()->subMinute()],
        (object) ['id' => 16, 'name' => 'Men\'s Health', 'created_at' => now()],
        (object) ['id' => 17, 'name' => 'Allergy', 'created_at' => now()],
        (object) ['id' => 18, 'name' => 'First Aid', 'created_at' => now()],
        (object) ['id' => 19, 'name' => 'Mental Health', 'created_at' => now()],
        (object) ['id' => 20, 'name' => 'Immunology', 'created_at' => now()]
    ]);
    
    // Convert the collection to a paginator with configurable items per page
    $page = request()->get('page', 1); 
    $perPage = request()->get('per_page', 10); 
    $offset = ($page - 1) * $perPage;
    
    
    $currentPageItems = $categoriesCollection->slice($offset, $perPage);
    
    
    $categories = new \Illuminate\Pagination\LengthAwarePaginator(
        $currentPageItems,
        $categoriesCollection->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );
    
    return view('dashboard.categories', compact('categories'));
    }
    public function products()
    {
            $products = [
        [
            'name' => 'Paracetamol',
            'category' => 'Pain Relief',
            'price' => 120.00,
            'quantity' => 50,
            'discount' => '0%',
            'expiry_date' => '12 Dec, 2025',
        ],
        [
            'name' => 'Amoxicillin',
            'category' => 'Antibiotic',
            'price' => 250.00,
            'quantity' => 80,
            'discount' => '5%',
            'expiry_date' => '01 Jan, 2026',
        ],
        [
            'name' => 'Cetirizine',
            'category' => 'Allergy',
            'price' => 90.00,
            'quantity' => 120,
            'discount' => '0%',
            'expiry_date' => '05 May, 2026',
        ],
    ];

    return view('dashboard.products', compact('products'));
    }
    public function Prescription()
    {
        // Get search query if provided
        $search = request('search');
        
        // Fetch real prescription data from database
        $prescriptionsQuery = \App\Models\Prescription::with('prescriptionItems.product')
            ->orderBy('created_at', 'desc');
        
        // Apply search filter if provided
        if ($search) {
            $prescriptionsQuery->where(function($query) use ($search) {
                $query->where('student_id', 'LIKE', "%{$search}%")
                      ->orWhere('prescription_number', 'LIKE', "%{$search}%")
                      ->orWhere('medicine_names', 'LIKE', "%{$search}%");
            });
        }
        
        // Paginate results
        $perPage = request('per_page', 10);
        $page = request('page', 1);
        $prescriptions = $prescriptionsQuery->paginate($perPage, ['*'], 'page', $page);
        
        // Transform prescription data to match the view expectations
        $prescriptions->getCollection()->transform(function ($prescription) {
            // Get medicine names from the prescription_items relationship
            $medicineNames = $prescription->prescriptionItems->map(function($item) {
                return $item->product->name ?? 'Unknown Medicine';
            })->unique()->values()->toArray();
            
            // Create a formatted medicine names string
            $medicineNamesString = implode(', ', array_slice($medicineNames, 0, 3));
            if (count($medicineNames) > 3) {
                $medicineNamesString .= ' and ' . (count($medicineNames) - 3) . ' more';
            }
            
            $prescription->medicine_names_display = $medicineNamesString;
            return $prescription;
        });

        return view('dashboard.prescription', compact('prescriptions'));
    }

    public function getPrescriptionDetails($id)
    {
        try {
            $prescription = \App\Models\Prescription::with('prescriptionItems.product')->findOrFail($id);
            
            // Format the response
            $prescriptionData = [
                'id' => $prescription->id,
                'prescription_number' => $prescription->prescription_number,
                'student_id' => $prescription->student_id,
                'date' => $prescription->created_at->format('d-M-Y H:i'),
                'notes' => $prescription->notes,
                'total_items' => $prescription->total_items,
                'total_quantity' => $prescription->total_quantity,
                'items' => $prescription->prescriptionItems->map(function($item) {
                    return [
                        'medicine' => $item->product->name ?? 'Unknown Medicine',
                        'quantity' => $item->quantity,
                        'notes' => $item->notes ?? ''
                    ];
                })
            ];
            
            return response()->json($prescriptionData);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Prescription not found'], 404);
        }
    }

    public function deletePrescription($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $prescription = \App\Models\Prescription::with('prescriptionItems.product')->findOrFail($id);
                
                // Store prescription number for response message
                $prescriptionNumber = $prescription->prescription_number;
                
                // Manually restore product quantities before deleting
                foreach ($prescription->prescriptionItems as $item) {
                    if ($item->product) {
                        // Get current product quantity
                        $currentQuantity = $item->product->quantity;
                        
                        // Restore the quantity to the product
                        $item->product->increment('quantity', $item->quantity);
                        
                        // Get updated quantity for logging
                        $item->product->refresh();
                        $newQuantity = $item->product->quantity;
                        
                        // Log for debugging
                        Log::info("Restored {$item->quantity} units to product {$item->product->name} (ID: {$item->product->id}). Quantity: {$currentQuantity} -> {$newQuantity}");
                    }
                }
                
                // Delete prescription items first
                $prescription->prescriptionItems()->delete();
                
                // Then delete the prescription
                $prescription->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => "Prescription {$prescriptionNumber} deleted successfully and product quantities restored"
                ]);
            });
            
        } catch (\Exception $e) {
            Log::error("Failed to delete prescription {$id}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete prescription: ' . $e->getMessage()
            ], 500);
        }
    }


    public function users()
    {
        $EntryUser = [
            [
                'id' => 2,
                'name' => 'Ernestina Stokes Sr.',
                'email' => 'prosacco.viva@example.org',
                'role' => 'admin',
                'created_date' => '09 Feb, 2022'
            ],
            [
                'id' => 3,
                'name' => 'Jamal Admin',
                'email' => 'admin@admin.com',
                'role' => 'super-admin',
                'created_date' => '08 Feb, 2022'
            ],
            [
                'id' => 4,
                'name' => 'Jermey Larkin V',
                'email' => 'ruth.theron@example.net',
                'role' => 'admin',
                'created_date' => '09 Feb, 2022'
            ],
            [
                'id' => 5,
                'name' => 'Julie Mertz',
                'email' => 'dgleason@example.net',
                'role' => 'admin',
                'created_date' => '09 Feb, 2022'
            ]
        ];

        $users = User::all();

        return view('dashboard.users', compact('users'));
    }

    public function deleteUsers($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }


    public function profile()
    {
        // Get actual authenticated user data
        $user = auth()->user();
        
        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'avatar' => null, // Will use placeholder for now
            'created_at' => $user->created_at->format('Y-m-d'),
            'updated_at' => $user->updated_at
        ];

        return view('dashboard.profile', compact('userData'));
    }
    public function addProduct()
    {
        $categories = [
            'Painkillers',
            'Antibiotics',
            'Antiseptics',
            'Antacids',
            'Laxatives',
            'Other'
        ];
        return view('dashboard.forms.addProduct', compact('categories'));
    }

    public function addUser()
    {
        // Define available roles for the form (could come from database in real application)
        $roles = [
            'admin' => 'Admin',
            'user' => 'User', 
            
        ];
        return view('dashboard.forms.addUser', compact('roles'));
    }

    public function addUserPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|string|in:admin,user',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_verified' => 1,
        ]);

        return redirect()->route('dashboard')->with('success', 'User added successfully.');
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8',
                'new_password_confirmation' => 'required|same:new_password',
            ]);

            $user = auth()->user();
            
            // Check if current password is correct
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect.'
                ], 422);
            }

            // Update the password
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully!'
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
                'message' => 'An error occurred while updating password.'
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            // Enhanced validation with custom messages
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:users,email,' . auth()->id(),
                'role' => 'required|string|in:admin,user',
            ], [
                'name.required' => 'Name is required.',
                'name.min' => 'Name must be at least 2 characters long.',
                'name.max' => 'Name must not exceed 255 characters.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already taken by another user.',
                'role.required' => 'User role is required.',
                'role.in' => 'Invalid user role selected.',
            ]);

            $user = auth()->user();
            
            // Update the user data
            $updated = $user->update([
                'name' => trim($request->name),
                'email' => trim($request->email),
                'role' => $request->role,
            ]);

            if (!$updated) {
                throw new \Exception('Failed to update profile in database.');
            }

            // Refresh the user model to get updated data
            $user->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
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
                'message' => 'An error occurred while updating profile: ' . $e->getMessage()
            ], 500);
        }
    }
}

