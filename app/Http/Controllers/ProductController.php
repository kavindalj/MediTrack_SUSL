<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get all products/medicines for the prescription form
     */
    public function getProducts()
    {
        // Array of products/medicines - you can later replace this with database queries
        $products = [
            ['id' => 1, 'name' => 'Paracetamol 500mg', 'stock' => 500],
            ['id' => 2, 'name' => 'Amoxicillin 250mg', 'stock' => 300],
            ['id' => 3, 'name' => 'Omeprazole 20mg', 'stock' => 200],
            ['id' => 4, 'name' => 'Ibuprofen 400mg', 'stock' => 400],
            ['id' => 5, 'name' => 'Cetirizine 10mg', 'stock' => 350],
            ['id' => 6, 'name' => 'Vitamin C 1000mg', 'stock' => 600],
            ['id' => 7, 'name' => 'Aspirin 75mg', 'stock' => 450],
            ['id' => 8, 'name' => 'Metformin 500mg', 'stock' => 250],
            ['id' => 9, 'name' => 'Atorvastatin 10mg', 'stock' => 180],
            ['id' => 10, 'name' => 'Azithromycin 500mg', 'stock' => 150],
            ['id' => 11, 'name' => 'Loratadine 10mg', 'stock' => 320],
            ['id' => 12, 'name' => 'Simvastatin 20mg', 'stock' => 275],
            ['id' => 13, 'name' => 'Prednisolone 5mg', 'stock' => 190],
            ['id' => 14, 'name' => 'Furosemide 40mg', 'stock' => 160],
            ['id' => 15, 'name' => 'Salbutamol Inhaler', 'stock' => 85],
            ['id' => 16, 'name' => 'Insulin Glargine', 'stock' => 45],
            ['id' => 17, 'name' => 'Warfarin 5mg', 'stock' => 120],
            ['id' => 18, 'name' => 'Digoxin 0.25mg', 'stock' => 95],
            ['id' => 19, 'name' => 'Hydrochlorothiazide 25mg', 'stock' => 220],
            ['id' => 20, 'name' => 'Clopidogrel 75mg', 'stock' => 140]
        ];

        return $products;
    }

    /**
     * Show the prescription form with products
     */
    public function showPrescriptionForm()
    {
        $products = $this->getProducts();
        return view('dashboard.forms.addSale', compact('products'));
    }
}
