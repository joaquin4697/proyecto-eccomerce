<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();
        $statuses = OrderStatus::cases();

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user', 'address');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'string'],
        ]);

        $newStatus = OrderStatus::from($request->status);

        if (! $order->status->canTransitionTo($newStatus)) {
            return back()->with('error', "No se puede pasar de \"{$order->status->label()}\" a \"{$newStatus->label()}\".");
        }

        $order->update(['status' => $newStatus]);

        return back()->with('success', 'Estado del pedido actualizado correctamente.');
    }
}