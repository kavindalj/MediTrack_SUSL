<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
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
    public function sale()
    {
        // Create a collection of sample sales data
        $salesCollection = collect([
            (object) [
            'id' => 1,
            'invoice_no' => 'INV-10001',
            'customer_name' => 'John Doe',
            'total_amount' => 472.50,
            'status' => 'Completed',
            'created_at' => now()->subDays(5),
            ],
            (object) [
            'id' => 2,
            'invoice_no' => 'INV-10002',
            'customer_name' => 'Jane Smith',
            'total_amount' => 298.75,
            'status' => 'Completed',
            'created_at' => now()->subDays(4),
            ],
            (object) [
            'id' => 3,
            'invoice_no' => 'INV-10003',
            'customer_name' => 'Robert Johnson',
            'total_amount' => 1250.00,
            'status' => 'Pending',
            'created_at' => now()->subDays(3),
            ],
            (object) [
            'id' => 4,
            'invoice_no' => 'INV-10004',
            'customer_name' => 'Mary Williams',
            'total_amount' => 785.25,
            'status' => 'Completed',
            'created_at' => now()->subDays(2),
            ],
            (object) [
            'id' => 5,
            'invoice_no' => 'INV-10005',
            'customer_name' => 'David Brown',
            'total_amount' => 345.00,
            'status' => 'Completed',
            'created_at' => now()->subDays(1),
            ],
            (object) [
            'id' => 6,
            'invoice_no' => 'INV-10006',
            'customer_name' => 'Sarah Miller',
            'total_amount' => 620.75,
            'status' => 'Pending',
            'created_at' => now()->subHours(12),
            ],
            (object) [
            'id' => 7,
            'invoice_no' => 'INV-10007',
            'customer_name' => 'Michael Davis',
            'total_amount' => 189.50,
            'status' => 'Completed',
            'created_at' => now()->subHours(6),
            ],
            (object) [
            'id' => 8,
            'invoice_no' => 'INV-10008',
            'customer_name' => 'Jennifer Garcia',
            'total_amount' => 425.00,
            'status' => 'Completed',
            'created_at' => now()->subHours(3),
            ],
            (object) [
            'id' => 9,
            'invoice_no' => 'INV-10009',
            'customer_name' => 'William Rodriguez',
            'total_amount' => 875.25,
            'status' => 'Pending',
            'created_at' => now(),
            ],
            (object) [
            'id' => 10,
            'invoice_no' => 'INV-10010',
            'customer_name' => 'Linda Martinez',
            'total_amount' => 550.00,
            'status' => 'Completed',
            'created_at' => now()->subMinutes(30),
            ],
            // Additional sales
            (object) [
            'id' => 11,
            'invoice_no' => 'INV-10011',
            'customer_name' => 'Kevin Lee',
            'total_amount' => 320.00,
            'status' => 'Completed',
            'created_at' => now()->subMinutes(25),
            ],
            (object) [
            'id' => 12,
            'invoice_no' => 'INV-10012',
            'customer_name' => 'Emily Clark',
            'total_amount' => 210.50,
            'status' => 'Pending',
            'created_at' => now()->subMinutes(20),
            ],
            (object) [
            'id' => 13,
            'invoice_no' => 'INV-10013',
            'customer_name' => 'Brian Adams',
            'total_amount' => 980.00,
            'status' => 'Completed',
            'created_at' => now()->subMinutes(15),
            ],
            (object) [
            'id' => 14,
            'invoice_no' => 'INV-10014',
            'customer_name' => 'Jessica Turner',
            'total_amount' => 430.75,
            'status' => 'Completed',
            'created_at' => now()->subMinutes(10),
            ],
            (object) [
            'id' => 15,
            'invoice_no' => 'INV-10015',
            'customer_name' => 'Chris Evans',
            'total_amount' => 760.00,
            'status' => 'Pending',
            'created_at' => now()->subMinutes(5),
            ],
            (object) [
            'id' => 16,
            'invoice_no' => 'INV-10016',
            'customer_name' => 'Patricia Moore',
            'total_amount' => 540.25,
            'status' => 'Completed',
            'created_at' => now()->subMinute(),
            ],
            (object) [
            'id' => 17,
            'invoice_no' => 'INV-10017',
            'customer_name' => 'George King',
            'total_amount' => 1200.00,
            'status' => 'Completed',
            'created_at' => now(),
            ],
            (object) [
            'id' => 18,
            'invoice_no' => 'INV-10018',
            'customer_name' => 'Nancy Scott',
            'total_amount' => 670.50,
            'status' => 'Pending',
            'created_at' => now(),
            ],
            (object) [
            'id' => 19,
            'invoice_no' => 'INV-10019',
            'customer_name' => 'Steven Young',
            'total_amount' => 390.00,
            'status' => 'Completed',
            'created_at' => now(),
            ],
            (object) [
            'id' => 20,
            'invoice_no' => 'INV-10020',
            'customer_name' => 'Laura Hill',
            'total_amount' => 850.75,
            'status' => 'Completed',
            'created_at' => now(),
            ],
        ]);
        
        
        // Convert the collection to a paginator with configurable items per page
        $page = request()->get('page', 1); 
        $perPage = request()->get('per_page', 10); 
        $offset = ($page - 1) * $perPage;
        
        // Filter by search term if provided
        $searchTerm = request()->get('search');
        if ($searchTerm) {
            $salesCollection = $salesCollection->filter(function($sale) use ($searchTerm) {
                return stripos($sale->customer_name, $searchTerm) !== false || 
                       stripos($sale->invoice_no, $searchTerm) !== false;
            });
        }
        
        $currentPageItems = $salesCollection->slice($offset, $perPage);
        
        // Create a Laravel paginator instance
        $sales = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $salesCollection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('dashboard.sale', compact('sales'));
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

        return view('dashboard.users', compact('EntryUser'));
    }
    public function profile()
    {
        // Sample user data - replace with actual authenticated user data
        $user = [
            'name' => 'Jamal Doe',
            'email' => 'admin@meditrack.com',
            'role' => 'admin',
            'avatar' => null, // Will use placeholder for now
            'created_at' => '2025-09-09',
            'updated_at' => now()
        ];

        return view('dashboard.profile', compact('user'));
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


}


    public function createSale()
    {
        // Sample medicines data - in a real app, you'd fetch from the database
        $medicines = [
            (object) ['id' => 1, 'name' => 'Paracetamol 500mg', 'price' => 5.00, 'stock' => 500],
            (object) ['id' => 2, 'name' => 'Amoxicillin 250mg', 'price' => 15.00, 'stock' => 300],
            (object) ['id' => 3, 'name' => 'Omeprazole 20mg', 'price' => 12.50, 'stock' => 200],
            (object) ['id' => 4, 'name' => 'Ibuprofen 400mg', 'price' => 7.50, 'stock' => 400],
            (object) ['id' => 5, 'name' => 'Cetirizine 10mg', 'price' => 6.00, 'stock' => 350],
            (object) ['id' => 6, 'name' => 'Vitamin C 1000mg', 'price' => 8.00, 'stock' => 600],
            (object) ['id' => 7, 'name' => 'Aspirin 75mg', 'price' => 4.50, 'stock' => 450],
            (object) ['id' => 8, 'name' => 'Metformin 500mg', 'price' => 10.00, 'stock' => 250],
            (object) ['id' => 9, 'name' => 'Atorvastatin 10mg', 'price' => 18.00, 'stock' => 180],
            (object) ['id' => 10, 'name' => 'Azithromycin 500mg', 'price' => 25.00, 'stock' => 150]
        ];
        
        return view('dashboard.forms.addSale', compact('medicines'));
}
}

}

