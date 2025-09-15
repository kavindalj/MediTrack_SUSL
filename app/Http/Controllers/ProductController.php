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
                ->where(function($query) {
                    $query->whereNull('expire_date') // Products without expiry date
                          ->orWhere('expire_date', '>', now()); // Or products that haven't expired
                })
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
                ->where(function($query) {
                    $query->whereNull('expire_date') // Products without expiry date
                          ->orWhere('expire_date', '>', now()); // Or products that haven't expired
                })
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
                ->where(function($query) {
                    $query->whereNull('expire_date') // Products without expiry date
                          ->orWhere('expire_date', '>', now()); // Or products that haven't expired
                })
                ->orderBy('name')
                ->get();

            return response()->json($products);

        } catch (\Exception $e) {
            \Log::error('Error fetching products by category: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    /**
     * Store a new product
     */
    public function storeProduct(Request $request)
    {
        // Custom validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'entry_date' => 'required|date',
            'expire_date' => 'required|date|after:today',
        ];

        // Add custom category validation only if category is "Other"
        if ($request->category === 'Other') {
            $rules['custom_category'] = 'required|string|max:255';
        }

        $request->validate($rules);

        try {
            // Determine the final category
            $finalCategory = $request->category;
            if ($request->category === 'Other' && !empty($request->custom_category)) {
                $finalCategory = $request->custom_category;
            }

            Product::create([
                'name' => $request->name,
                'category' => $finalCategory,
                'quantity' => $request->quantity,
                'entry_date' => $request->entry_date,
                'expire_date' => $request->expire_date,
            ]);

            return redirect()->route('dashboard.products')->with('success', 'Product added successfully.');
        } catch (\Exception $e) {
            \Log::error('Error adding product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add product. Please try again.');
        }
    }

    /**
     * Show the add product form
     */
    public function addProduct()
    {
        // Fetch unique categories from products table
        $dbCategories = Product::distinct()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->pluck('category')
            ->sort()
            ->values()
            ->toArray();
        
        // Add "Other" option at the end
        $categories = array_merge($dbCategories, ['Other']);
        
        return view('dashboard.forms.addProduct', compact('categories'));
    }

    /**
     * Delete a product
     */
    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json(['message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting product'], 500);
        }
    }
}
