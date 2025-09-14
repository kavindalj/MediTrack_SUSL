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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $stats = [
            'total_drugs' => Product::count(),
            'product_categories' => Product::distinct('category')->count('category'),
            'expired_products' => Product::where('expire_date', '<', now())->where('quantity', '>', 0)->count(),
            'system_users' => User::count()
        ];

        // Fetch today's prescriptions data
        $todaySales = Prescription::with('prescriptionItems.product')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($prescription) {
                // Get medicine names from prescription items
                $medicineNames = $prescription->prescriptionItems->map(function($item) {
                    return $item->product->name ?? $item->medicine_name ?? 'Unknown Medicine';
                })->unique()->values()->toArray();
                
                // Create a formatted medicine names string
                $medicineNamesString = implode(', ', array_slice($medicineNames, 0, 3));
                if (count($medicineNames) > 3) {
                    $medicineNamesString .= ' and ' . (count($medicineNames) - 3) . ' more';
                }
                
                return [
                    'student_id' => $prescription->student_id,
                    'medicine_names' => $medicineNamesString,
                    'total_items' => $prescription->total_items,
                    'total_quantity' => $prescription->total_quantity,
                    'prescription_number' => $prescription->prescription_number,
                    'created_at' => $prescription->created_at->format('d M, Y')
                ];
            });

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
        $prescriptionsQuery = Prescription::with('prescriptionItems.product')
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

