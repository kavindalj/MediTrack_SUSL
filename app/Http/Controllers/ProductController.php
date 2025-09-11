<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Get all products/medicines for the prescription form
     */
    public function getProducts()
    {
        try {
            // Fetch products from database
            $products = Product::select('id', 'name', 'quantity as stock', 'category', 'expire_date')
                ->where('quantity', '>', 0) // Only get products with stock
                ->orderBy('name')
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'stock' => $product->stock,
                        'category' => $product->category,
                        'expire_date' => $product->expire_date ? $product->expire_date->format('Y-m-d') : null,
                    ];
                })
                ->toArray();

            return $products;

        } catch (\Exception $e) {
            // Log error and return empty array
            \Log::error('Error fetching products: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Search products by name
     */
    public function searchProducts(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        try {
            $products = Product::select('id', 'name', 'quantity as stock', 'category')
                ->where('name', 'LIKE', '%' . $query . '%')
                ->where('quantity', '>', 0)
                ->orderBy('name')
                ->limit(10)
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'stock' => $product->stock,
                        'category' => $product->category,
                    ];
                });

            return response()->json($products);

        } catch (\Exception $e) {
            \Log::error('Error searching products: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    /**
     * Show the prescription form with products
     */
    public function showPrescriptionForm()
    {
        $products = $this->getProducts();
        return view('dashboard.forms.addPrescription', compact('products'));
    }

    /**
     * Get products by category
     */
    public function getProductsByCategory($category)
    {
        try {
            $products = Product::select('id', 'name', 'quantity as stock', 'category')
                ->where('category', $category)
                ->where('quantity', '>', 0)
                ->orderBy('name')
                ->get();

            return response()->json($products);

        } catch (\Exception $e) {
            \Log::error('Error fetching products by category: ' . $e->getMessage());
            return response()->json([]);
        }
    }
}
