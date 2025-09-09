<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('dashboard.categories');
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
        return view('dashboard.forms.addUser');
    }
}