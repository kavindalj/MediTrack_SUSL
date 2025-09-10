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
        return view('dashboard.products');
    }
    public function sale()
    {
        return view('dashboard.sale');
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
        return view('dashboard.forms.addProduct');
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