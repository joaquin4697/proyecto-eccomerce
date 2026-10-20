<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $products = Auth::user()->wishlist()->with('categories')->get();

        return view('wishlist.index', compact('products'));
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();

    if ($user->wishlist()->where('product_id', $product->id)->exists()) {
        $user->wishlist()->detach($product->id);
        $message = 'Producto quitado de tu lista de deseos.';
    } else {
        $user->wishlist()->attach($product->id, ['created_at' => now()]);
        $message = 'Producto agregado a tu lista de deseos.';
    }

        return back()->with('success', $message);
    }   
}