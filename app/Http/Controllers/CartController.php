<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        $total = $cartItems->sum(fn ($item) => $item->subtotal());
        $addresses = Auth::user()->addresses;

        return view('cart.index', compact('cartItems', 'total', 'addresses'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $quantity = $request->input('quantity', 1);

        $item = CartItem::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        $item->quantity = $item->exists ? $item->quantity + $quantity : $quantity;
        $item->save();

        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        $this->authorizeOwnership($cartItem);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cantidad actualizada.');
    }

    public function remove(CartItem $cartItem)
    {
        $this->authorizeOwnership($cartItem);

        $cartItem->delete();

        return back()->with('success', 'Producto quitado del carrito.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'address_id' => ['required', 'exists:addresses,id'],
        ]);

        $cartItems = Auth::user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Tu carrito está vacío.');
        }

        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return back()->with('error', "No hay stock suficiente de \"{$item->product->name}\".");
            }
        }

        $order = DB::transaction(function () use ($cartItems, $request) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'address_id' => $request->address_id,
                'status' => 'pendiente',
                'total' => 0,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            $order->recalculateTotal();

            Auth::user()->cartItems()->delete();

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', '¡Pedido realizado correctamente!');
    }

    private function authorizeOwnership(CartItem $cartItem): void
    {
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }
    }
}