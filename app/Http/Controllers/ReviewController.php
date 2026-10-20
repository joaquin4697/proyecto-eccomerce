<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $userId = auth()->id();

        $hasPurchased = Order::where('user_id', $userId)
            ->where('status', OrderStatus::Entregado->value)
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();

        if (! $hasPurchased) {
            return back()->with('error', 'Solo podés dejar una reseña de productos que hayas comprado y recibido.');
        }

        Review::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $productId],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return back()->with('success', '¡Gracias por compartir tu opinión!');
    }
}