<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class ProductApiController extends Controller
{
    public function index()
    {
        
        $products = Product::with('categories')->get();

        
        return response()->json([
            'success' => true,
            'message' => 'Lista de productos obtenida correctamente',
            'data'    => $products
        ], 200);
    }
    
    public function show($id)
    {
       
        $product = Product::with(['categories', 'reviews.user'])->find($id);

        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $product
        ], 200);
    }

    public function categories()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'data'    => $categories
        ], 200);
    }
}