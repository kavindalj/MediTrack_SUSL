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
    
    public function products()
    {
        // Fetch real products from database
        $products = Product::select('id', 'name', 'category', 'quantity', 'expire_date', 'entry_date')
            ->orderBy('name')
            ->get();

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

    public function users()
    {
        $users = User::all();
        return view('dashboard.users', compact('users'));
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
}

