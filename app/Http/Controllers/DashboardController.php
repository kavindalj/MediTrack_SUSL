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
            'product_categories' => 170,
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
}
